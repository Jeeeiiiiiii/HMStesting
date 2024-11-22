<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\User;
use App\Models\Admin;
use App\Models\Department;
use App\Models\TriageNurse;
use App\Models\EmergencyRoom;
use App\Models\TemporaryUser;
use App\Models\Profile;
use App\Models\AdminProfile;
use App\Models\NurseProfile;
use App\Models\DoctorProfile;
use App\Models\TriageNurseProfile;
use App\Models\Session;
use App\Models\DoctorSession;
use App\Models\AdminSession;
use App\Models\NurseSession;
use App\Models\TriageNurseSession;
use App\Models\DepartmentSession;
use App\Models\EmergencyRoomSession;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\SimpleQRCode\Facades\SimpleQRCode;
use Hash;
use Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    
    public function login(){

        return view('login');
    }


    public function register(){

        return view('register')->with('success', 'Login successful');
    }

    public function registerSave(Request $request)
    {
        // Log the incoming request data (without password for security)
        Log::info('Register request data: ', $request->except('password'));

        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email', // Ensure the email is unique for Admin model
            'password' => ['required','confirmed','min:8','regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'], [
            'password.regex' => 'The password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.',
            ]
        ])->validate();

        try {
            // Attempt to create the admin user
            Log::info('Creating Admin user...'); // Debug point 1
            $user = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Calculate age based on birthday
            function calculateAge($birthday) {
                return \Carbon\Carbon::parse($birthday)->age; // Use Carbon to calculate age
            }

            // Your existing code where you create the admin profile
            $birthday = $request->birthday; // Get the birthday from the request
            $age = calculateAge($birthday); // Calculate the age based on the birthday

            // Log after successfully creating the user
            Log::info('Admin user created successfully with ID: ' . $user->id); // Debug point 2

            // Create the AdminProfile record
            Log::info('Creating AdminProfile for Admin ID: ' . $user->id); // Debug point 3
            AdminProfile::create([
                'admin_id' => $user->id, // Associate the profile with the admin
                'name' => $request->name,
                'age' => $age, // Use the calculated age
                'birthday' => $request->birthday,
                'birthplace' => $request->birthplace,
                'civil_status' => $request->civil_status,
                'religion' => $request->religion,
                'nationality' => $request->nationality,
                'gender' => $request->gender,
                'telephone_no' => $request->telephone_no,
            ]);

            // Log successful profile creation
            Log::info('AdminProfile created successfully for Admin ID: ' . $user->id); // Debug point 4

            // If creation is successful, redirect to login with success message
            return redirect()->route('login')->with('success', 'Registration successful, please login.');

        } catch (\Exception $e) {
            // Log the error message with detailed context
            Log::error('Error occurred during registration: ' . $e->getMessage()); // Debug point 5

            // Log the stack trace for deeper debugging
            Log::error($e->getTraceAsString());

            // If an exception occurs, redirect to login with error message
            return redirect()->route('login')->with('error', 'Registration unsuccessful, please try again.');
        }
    }


    public function login_submit(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password'=>'required',
        ]);
       
        $credentials = $request->only('email', 'password');

        // Detect device and browser
        $agent = new Agent();
        $deviceName = $agent->platform() . ' ' . $agent->version($agent->platform());
        $browserName = $agent->browser() . ' ' . $agent->version($agent->browser());

        if(Auth::guard('admin')->attempt($credentials)){
                $user=Admin::where('email',$request->input('email'))->first();
                        Auth::guard('admin')->login($user);

                // Log session for admin
                AdminSession::create([
                    'admin_id' => $user->id,
                    'device_name' => $deviceName,
                    'browser_name' => $browserName,
                    'last_active_at' => now(), // Include last_active_at in the same array
                ]);


            return redirect()->route('admin_dashboard')->with('success', 'Login successful');
            } 
        
        elseif(Auth::guard('doctor')->attempt($credentials)){
            $user = Doctor::where('email', $request->input('email'))->first();
            Auth::guard('doctor')->login($user);

            // Log session for doctor
            DoctorSession::create([
                'doctor_id' => $user->id,
                'device_name' => $deviceName,
                'browser_name' => $browserName,
                'last_active_at' => now(), // Include last_active_at in the same array
            ]);


            return redirect()->route('doctor_dashboard')->with('success', 'Login successful');
        } 
        
        elseif(Auth::guard('nurse')->attempt($credentials)){
            $user = Nurse::where('email', $request->input('email'))->first();
            Auth::guard('nurse')->login($user);

            // Log session for nurse
            NurseSession::create([
                'nurse_id' => $user->id,
                'device_name' => $deviceName,
                'browser_name' => $browserName,
                'last_active_at' => now(), // Include last_active_at in the same array
            ]);


            return redirect()->route('nurse_dashboard')->with('success', 'Login successful');
        } 
        
        elseif(Auth::guard('triagenurse')->attempt($credentials)){
            $user = TriageNurse::where('email', $request->input('email'))->first();
            Auth::guard('nurse')->login($user);

            // Log session for triage nurse
            TriageNurseSession::create([
                'triage_nurse_id' => $user->id,
                'device_name' => $deviceName,
                'browser_name' => $browserName,
                'last_active_at' => now(), // Include last_active_at in the same array
            ]);


            return redirect()->route('triagenurse_dashboard')->with('success', 'Login successful');
        } 
        
        elseif (Auth::guard('patient')->attempt($credentials)) {
            $user = Patient::where('email', $request->input('email'))->first();
            Auth::guard('patient')->login($user);

            // Log session for patient
            Session::create([
                'patient_id' => $user->id,
                'device_name' => $deviceName,
                'browser_name' => $browserName,
                'last_active_at' => now(), // Include last_active_at in the same array
            ]);
            return redirect()->route('patient_dashboard', ['id' => $user->id])->with('success', 'Login successful as patient');
        }

        elseif (Auth::guard('department')->attempt($credentials)) {
            $user = Department::where('email', $request->input('email'))->first();
            Auth::guard('department')->login($user);

            // Log session for department
            DepartmentSession::create([
                'department_id' => $user->id,
                'device_name' => $deviceName,
                'browser_name' => $browserName,
                'last_active_at' => now(), // Include last_active_at in the same array
            ]);

            return redirect()->route('department_dashboard', ['id' => $user->id])->with('success', 'Login successful as department');
        }

        elseif (Auth::guard('eroom')->attempt($credentials)) {
            $user = EmergencyRoom::where('email', $request->input('email'))->first();
            Auth::guard('eroom')->login($user);

            // Log session for department
            EmergencyRoomSession::create([
                'emergency_room_id' => $user->id,
                'device_name' => $deviceName,
                'browser_name' => $browserName,
                'last_active_at' => now(), // Include last_active_at in the same array
            ]);

            return redirect()->route('emergencyroom_dashboard', ['id' => $user->id])->with('success', 'Login successful as department');
        }
                
        else {
            return redirect()->route('login')->with('error', 'Login unsuccessful');
        }

        
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
 
        $request->session()->invalidate();
 
        return redirect('/login');
    }

    ////////// Doctor Logic
    public function final_registration(Request $request, $token)
{
    // Validate the token
    $temporaryUser = TemporaryUser::where('registration_token', $token)->first();

    if (!$temporaryUser) {
        return redirect()->route('login')->with('error', 'Invalid confirmation token.');
    }

    // Pass the token to the view
    return view('admin.Doctors.registration', compact('token'));
}

    public function doctor_post_final(Request $request)
{
    // Validate the token
    $temporaryUser = TemporaryUser::where('registration_token', $request->token)->first();

    if (!$temporaryUser) {
        return redirect()->route('login')->with('error', 'Invalid confirmation token.');
    }

    // Validate the input
    Validator::make($request->all(), [
        'name' => 'required',
        'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        'password.regex' => 'The password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.',
    ])->validate();

    // Calculate age based on birthday
    function calculateAge($birthday) {
        return \Carbon\Carbon::parse($birthday)->age; // Use Carbon to calculate age
    }

    // Your existing code where you create the admin profile
    $birthday = $request->birthday; // Get the birthday from the request
    $age = calculateAge($birthday); // Calculate the age based on the birthday

    // Create the Doctor record
    $doctor = Doctor::create([
        'email' => $temporaryUser->email,
        'password' => Hash::make($request->password),
        'name' => $request->name,
        // ... other user fields
    ]);

    // Create the DoctorProfile record, using the ID of the newly created doctor
    DoctorProfile::create([
        'doctor_id' => $doctor->id, // Associate the profile with the doctor
        'name' => $request->name,
        'age' => $age,
        'birthday' => $request->birthday,
        'birthplace' => $request->birthplace,
        'specialization' => $request->specialization,
        'civil_status' => $request->civil_status,
        'religion' => $request->religion,
        'nationality' => $request->nationality,
        'gender' => $request->gender,
        'telephone_no' => $request->telephone_no,
    ]);

    // Now delete the temporary user
    $temporaryUser->delete();

    return redirect('login')->withSuccess('Doctor Registration Completed');
}


    ////////// Patient Logic
    public function patient_final_registration(Request $request, $token)
{
    // Validate the token
    $temporaryUser = TemporaryUser::where('registration_token', $token)->first();

    if (!$temporaryUser) {
        return redirect()->route('login')->with('error', 'Invalid confirmation token.');
    }

    // Pass the token to the view
    return view('admin.Patients.registration', compact('token'));
}

    public function patient_post_final(Request $request)
{
    // Validate the token
    $temporaryUser = TemporaryUser::where('registration_token', $request->token)->first();

    if (!$temporaryUser) {
        return redirect()->route('login')->with('error', 'Invalid confirmation token.');
    }

    // Validate the input
    Validator::make($request->all(), [
        'name' => 'required',
        'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        'password.regex' => 'The password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.',
    ])->validate();

    // Calculate age based on birthday
    function calculateAge($birthday) {
        return \Carbon\Carbon::parse($birthday)->age; // Use Carbon to calculate age
    }

    // Your existing code where you create the admin profile
    $birthday = $request->birthday; // Get the birthday from the request
    $age = calculateAge($birthday); // Calculate the age based on the birthday

    // Create the Patient record
    $patient = Patient::create([
        'email' => $temporaryUser->email,
        'password' => Hash::make($request->password),
        'name' => $request->name,
        // ... other user fields
    ]);

    // Create the Profile record, using the ID of the newly created Patient
    Profile::create([
        'patient_id' => $patient->id, // Associate the profile with the patient
        'name' => $request->name,
        'age' => $age,
        'birthday' => $request->birthday,
        'birthplace' => $request->birthplace,
        'civil_status' => $request->civil_status,
        'religion' => $request->religion,
        'nationality' => $request->nationality,
        'gender' => $request->gender,
        'telephone_no' => $request->telephone_no,
    ]);

    // Now delete the temporary user
    $temporaryUser->delete();

    return redirect('login')->withSuccess('Patient Registration Completed');
}


    ////////// Nurse Logic
public function nurse_final_registration(Request $request, $token)
{
    // Validate the token
    $temporaryUser = TemporaryUser::where('registration_token', $token)->first();

    if (!$temporaryUser) {
        return redirect()->route('login')->with('error', 'Invalid confirmation token.');
    }

    // Pass the token to the view
    return view('admin.Nurse.registration', compact('token'));
}

    public function nurse_post_final(Request $request)
    {
        // Validate the token
        $temporaryUser = TemporaryUser::where('registration_token', $request->token)->first();

        if (!$temporaryUser) {
            return redirect()->route('login')->with('error', 'Invalid confirmation token.');
        }

        // Validate the input
        Validator::make($request->all(), [
            'name' => 'required',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            'password.regex' => 'The password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.',
        ])->validate();

        // Calculate age based on birthday
        function calculateAge($birthday) {
            return \Carbon\Carbon::parse($birthday)->age; // Use Carbon to calculate age
        }

        // Your existing code where you create the admin profile
        $birthday = $request->birthday; // Get the birthday from the request
        $age = calculateAge($birthday); // Calculate the age based on the birthday

        // Create the nurse
        $user = Nurse::create([
            'email' => $temporaryUser->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            // ... other user fields
        ]);

        // Create the NurseProfile record, using the ID of the newly created nurse
        NurseProfile::create([
            'nurse_id' => $user->id, // Associate the profile with the nurse
            'name' => $request->name,
            'age' => $age,
            'birthday' => $request->birthday,
            'birthplace' => $request->birthplace,
            'civil_status' => $request->civil_status,
            'religion' => $request->religion,
            'nationality' => $request->nationality,
            'gender' => $request->gender,
            'telephone_no' => $request->telephone_no,
        ]);

        // Now delete the temporary user
        $temporaryUser->delete();

        return redirect('login')->withSuccess('Nurse Registration Completed');
    }


    ////////// TriageNurse Logic
    public function triage_nurse_final_registration(Request $request, $token)
    {
    // Validate the token
    $temporaryUser = TemporaryUser::where('registration_token', $token)->first();

    if (!$temporaryUser) {
        return redirect()->route('login')->with('error', 'Invalid confirmation token.');
    }

    // Pass the token to the view
    return view('admin.TriageNurse.registration', compact('token'));
    }


    
    public function triage_nurse_post_final(Request $request)
    {
        // Validate the token
        $temporaryUser = TemporaryUser::where('registration_token', $request->token)->first();

        if (!$temporaryUser) {
            return redirect()->route('login')->with('error', 'Invalid confirmation token.');
        }

        // Validate the input
        Validator::make($request->all(), [
            'name' => 'required',
            'password' => ['required','confirmed','min:8','regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        ])->validate();

        // Calculate age based on birthday
        function calculateAge($birthday) {
            return \Carbon\Carbon::parse($birthday)->age; // Use Carbon to calculate age
        }

        // Your existing code where you create the admin profile
        $birthday = $request->birthday; // Get the birthday from the request
        $age = calculateAge($birthday); // Calculate the age based on the birthday

        // Create the triage nurse
        $user = TriageNurse::create([
            'email' => $temporaryUser->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            // ... other user fields
        ]); 

        // Create the profile
        TriageNurseProfile::create([
            'triage_nurse_id' => $user->id,
            'name' => $request->name,
            'age' => $age,
            'birthday' => $request->birthday,
            'birthplace' => $request->birthplace,
            'civil_status' => $request->civil_status,
            'religion' => $request->religion,
            'nationality' => $request->nationality,
            'gender' => $request->gender,
            'telephone_no' => $request->telephone_no,
        ]);

        // Now delete the temporary user
        $temporaryUser->delete();

        return redirect('login')->withSuccess('Triage Nurse Registration Completed');
    }


    ////////// Department Logic
    public function department_final_registration(Request $request, $token)
    {
        // Validate the token
        $temporaryUser = TemporaryUser::where('registration_token', $token)->first();

        if (!$temporaryUser) {
            return redirect()->route('login')->with('error', 'Invalid confirmation token.');
        }

        // Pass the token to the view
        return view('admin.Department.registration', compact('token'));
    }

    public function department_post_final(Request $request)
    {
        // Validate the token
        $temporaryUser = TemporaryUser::where('registration_token', $request->token)->first();

        if (!$temporaryUser) {
            return redirect()->route('login')->with('error', 'Invalid confirmation token.');
        }

        // Validate the input
        Validator::make($request->all(), [
            'department_name' => 'required',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            'password.regex' => 'The password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.',
        ])->validate();

        // Create the department
        $department = Department::create([
            'email' => $temporaryUser->email,
            'password' => Hash::make($request->password),
            'department_name' => $request->department_name,
            'department_code' => $request->department_code,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            // ... other department fields
        ]);

        // Now delete the temporary user
        $temporaryUser->delete();

        return redirect('login')->withSuccess('Department Registration Completed');
    }





    ////////// Emergency Room Logic
    public function emergency_room_final_registration(Request $request, $token)
    {
        // Validate the token
        $temporaryUser = TemporaryUser::where('registration_token', $token)->first();

        if (!$temporaryUser) {
            return redirect()->route('login')->with('error', 'Invalid confirmation token.');
        }

        // Pass the token to the view
        return view('admin.EmergencyRoom.registration', compact('token'));
    }

    public function emergency_room_post_final(Request $request)
    {
        // Validate the token
        $temporaryUser = TemporaryUser::where('registration_token', $request->token)->first();

        if (!$temporaryUser) {
            return redirect()->route('login')->with('error', 'Invalid confirmation token.');
        }

        // Validate the input
        Validator::make($request->all(), [
            'department_name' => 'required',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            'password.regex' => 'The password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.',
        ])->validate();

        // Create the department
        $department = EmergencyRoom::create([
            'email' => $temporaryUser->email,
            'password' => Hash::make($request->password),
            'department_name' => $request->department_name,
            'department_code' => $request->department_code,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            // ... other department fields
        ]);

        // Now delete the temporary user
        $temporaryUser->delete();

        return redirect('login')->withSuccess('Department Registration Completed');
    }

}
