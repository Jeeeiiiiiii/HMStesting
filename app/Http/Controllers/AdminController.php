<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\TriageNurse;
use App\Models\EmergencyRoom;
use App\Models\BedControl;
use App\Models\Department;
use App\Models\TemporaryUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Hash;
// use Illuminate\Support\Facades\Auth;
use Auth;
use Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;


class AdminController extends Controller
{
    public function dashboard() {
        $admin = auth()->guard('admin')->user();
        
        // Retrieve counts for each category
        $doctorsCount = Doctor::count();
        $nursesCount = Nurse::count();
        $departmentCount = Department::count();
        $patientsCount = Patient::count();
        $triageNursesCount = TriageNurse::count();
        $emergencyRoomCount = EmergencyRoom::count();
        
        return view('admin.AdminDashboard', compact('admin', 'doctorsCount', 'nursesCount', 'departmentCount', 'patientsCount', 'triageNursesCount', 'emergencyRoomCount'));
    }
    




/////////////////////////////////////////////////////// Doctor Logic

    public function DoctorRegister(){
        $admin = auth()->guard('admin')->user();
        return view('admin.Doctors.Add', compact('admin'));
    }


    public function doctorPostRegistration(Request $request): RedirectResponse
    {  
        $request->validate([
        'email' => 'required|email|unique:doctors,email',
    ]);

    $token = Str::random(32);
    
    $temporaryUser = TemporaryUser::create([
        'email' => $request->get('email'),
        'registration_token' => $token,
    ]);

    

    // Send registration confirmation email with link including token
    Mail::send('email.registration_link', ['email' => $temporaryUser->email, 'token' => $token], function($message) use ($temporaryUser) {
        $message->to($temporaryUser->email)->subject('Complete Your Registration');
    });

    return redirect('admin/dashboard')->withSuccess('A confirmation email has been sent to your address.');
    }


    public function doctors(Request $request) 
    {
        $admin = auth()->guard('admin')->user();
        
        // Get the search query from the request
        $search = $request->input('search');

        // Query nurses based on the search input
        $doctors = Doctor::where(function($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            }
        })->get();
        
        // Pass the nurses and admin to the view
        return view('admin.Doctors.DoctorsDashboard', compact('doctors', 'admin'));
    }

    public function showDoctorProfile($id)
    {
        $admin = auth()->guard('admin')->user();
        $doctor = Doctor::with('departments')->findOrFail($id);

        // Get the status filter from the request
        $status = request('status', 'admitted');

        // Fetch patients that the doctor has managed, filtered by status
        $patients = Patient::whereHas('patientrecord', function($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })
        ->where('status', $status) // Filter by patient status
        ->get();

        return view('admin.Doctors.Profile', compact('admin', 'doctor', 'patients'));
    }









    ///////////////////////////////////////////////// Patient Logic

    public function PatientRegister(){
        $admin = auth()->guard('admin')->user();

        return view('admin.Patients.Add', compact('admin'));
    }


    public function patientPostRegistration(Request $request): RedirectResponse
    {  
        $request->validate([
        'email' => 'required|email|unique:patients,email',
    ]);

    $token = Str::random(32);
    
    $temporaryUser = TemporaryUser::create([
        'email' => $request->get('email'),
        'registration_token' => $token,
    ]);

    

    // Send registration confirmation email with link including token
    Mail::send('email.patient_registration_link', ['email' => $temporaryUser->email, 'token' => $token], function($message) use ($temporaryUser) {
        $message->to($temporaryUser->email)->subject('Complete Your Registration');
    });

    return redirect('admin/dashboard')->withSuccess('A confirmation email has been sent to your address.');
    }


    public function patients(Request $request)
    {
    $admin = auth()->guard('admin')->user();
    
    // Get the search input and status, with 'admitted' as the default status
    $search = $request->input('search');
    $status = $request->input('status', 'admitted'); 

    // Retrieve patients based on the search query and status
    $patients = Patient::where('status', $status) // Filter by status first
        ->when($search, function($query, $search) {
            // If there is a search term, filter by name or email
            return $query->where(function($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%');
            });
        })->get();
    
    // Pass the filtered patients and the admin to the view
    return view('admin.Patients.PatientsDashboard', compact('patients', 'admin'));
    }

    public function showPatientProfile($id)
    {
        $admin = auth()->guard('admin')->user();
        $patient = Patient::findOrFail($id);

        

        return view('admin.Patients.Profile', compact('admin', 'patient'));
    }










    ///////////////////////////////////////////////// Nurse Logic

    public function NurseRegister(){
        $admin = auth()->guard('admin')->user();
        return view('admin.Nurse.Add', compact('admin'));
    }


    public function nursePostRegistration(Request $request): RedirectResponse
    {  
        $request->validate([
        'email' => 'required|email|unique:nurses,email',
    ]);

    $token = Str::random(32);
    
    $temporaryUser = TemporaryUser::create([
        'email' => $request->get('email'),
        'registration_token' => $token,
    ]);

    

    // Send registration confirmation email with link including token
    Mail::send('email.nurse_registration_link', ['email' => $temporaryUser->email, 'token' => $token], function($message) use ($temporaryUser) {
        $message->to($temporaryUser->email)->subject('Complete Your Registration');
    });

    return redirect('admin/dashboard')->withSuccess('A confirmation email has been sent to your address.');
    }


    public function nurses(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        
        // Get the search query from the request
        $search = $request->input('search');

        // Query nurses based on the search input
        $nurses = Nurse::where(function($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            }
        })->get();
        
        // Pass the nurses and admin to the view
        return view('admin.Nurse.Nurses', compact('nurses', 'admin'));
    }

    public function showNurseProfile($id)
    {
        $admin = auth()->guard('admin')->user();
        $nurse = Nurse::with('departments')->findOrFail($id);

        // Get the status filter from the request
        $status = request('status', 'admitted');

        // Fetch patients that the nurse has managed, filtered by status
        $patients = Patient::whereHas('patientrecord', function($query) use ($nurse) {
            $query->where('nurse_id', $nurse->id);
        })
        ->where('status', $status) // Filter by patient status
        ->get();

        return view('admin.Nurse.Profile', compact('admin', 'nurse', 'patients'));
    }







    ///////////////////////////////////////////////// Triage Nurse Logic

    public function Triage_NurseRegister(){
        $admin = auth()->guard('admin')->user();
        return view('admin.TriageNurse.Add', compact('admin'));
    }


    public function triage_nursePostRegistration(Request $request): RedirectResponse
    {  
        $request->validate([
        'email' => 'required|email|unique:triage_nurses,email',
    ]);

    $token = Str::random(32);
    
    $temporaryUser = TemporaryUser::create([
        'email' => $request->get('email'),
        'registration_token' => $token,
    ]);

    

    // Send registration confirmation email with link including token
    Mail::send('email.triage_nurse_registration_link', ['email' => $temporaryUser->email, 'token' => $token], function($message) use ($temporaryUser) {
        $message->to($temporaryUser->email)->subject('Complete Your Registration');
    });

    return redirect('admin/dashboard')->withSuccess('A confirmation email has been sent to your address.');
    }


    public function triagenurse(Request $request){
        $admin = auth()->guard('admin')->user();
        
        // Get the search query from the request
        $search = $request->input('search');

        // Query nurses based on the search input
        $triagenurses = TriageNurse::where(function($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            }
        })->get();
        
        // Pass the nurses and admin to the view
        return view('admin.TriageNurse.TriageNurseDashboard', compact('triagenurses', 'admin'));
    }

    public function showTriageProfile($id)
    {
        $admin = auth()->guard('admin')->user();
        $triagenurse = TriageNurse::with('departments')->findOrFail($id);

        

        return view('admin.TriageNurse.Profile', compact('admin', 'triagenurse'));
    }









    ///////////////////////////////////////////////// Department Logic

    public function departments(Request $request) 
    {
        $admin = auth()->guard('admin')->user();
        
        // Get the search query from the request
        $search = $request->input('search');

        // Query nurses based on the search input
        $departments = Department::where(function($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            }
        })->get();
        
        // Pass the departments and admin to the view
        return view('admin.Department.Departments', compact('departments', 'admin'));
    }


    public function departmentsDetail($id, Request $request) 
    {
        $admin = auth()->guard('admin')->user();
        
        // Get the search query and status filter from the request
        $search = $request->input('search');
        $status = $request->input('status', 'doctor'); // Default to 'doctor'

        // Find the specific department by ID
        $department = Department::findOrFail($id);

        // Query doctors, nurses, or triage nurses associated with this department based on the status
        if ($status == 'doctor') {
            $staff = $department->doctors()
                ->where(function($query) use ($search) {
                    if ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    }
                })->get();
        } elseif ($status == 'nurse') {
            $staff = $department->nurses()
                ->where(function($query) use ($search) {
                    if ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    }
                })->get();
        } else { // Triage nurses
            $staff = $department->triage_nurse() // Assuming you have a relationship defined
                ->where(function($query) use ($search) {
                    if ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    }
                })->get();
        }

        // Pass the filtered staff and department to the view
        return view('admin.Department.Details', compact('staff', 'admin', 'department', 'status'));
    }



    public function DepartmentRegister(){
        $admin = auth()->guard('admin')->user();
        return view('admin.Department.Add', compact('admin'));
    }


    public function departmentPostRegistration(Request $request): RedirectResponse
    {  
        $request->validate([
        'email' => 'required|email|unique:departments,email',
    ]);

    $token = Str::random(32);
    
    $temporaryUser = TemporaryUser::create([
        'email' => $request->get('email'),
        'registration_token' => $token,
    ]);

    // Send registration confirmation email with link including token
    Mail::send('email.department_registration_link', ['email' => $temporaryUser->email, 'token' => $token], function($message) use ($temporaryUser) {
        $message->to($temporaryUser->email)->subject('Complete Your Registration');
    });

    return redirect('admin/dashboard')->withSuccess('A confirmation email has been sent to your address.');
    }


    public function assignDoctor()
    {
        $admin = auth()->guard('admin')->user();

        // Fetch doctors and departments to display in the form
        $doctors = Doctor::all();
        $departments = Department::all();

        return view('admin.Department.AssignDoctor', compact('doctors', 'departments', 'admin'));
    }


    public function storeAssignDoctor(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Find the doctor and assign the department using a pivot table
        $doctor = Doctor::find($validated['doctor_id']);
        $doctor->departments()->syncWithoutDetaching($validated['department_id']);  // Add department without removing existing ones

        return redirect()->route('department_details', ['id' => $validated['department_id']])
        ->with('success', 'Doctor has been assigned to the department.');
    }


    public function assignNurse()
    {
        $admin = auth()->guard('admin')->user();

        // Fetch doctors and departments to display in the form
        $nurses = Nurse::all();
        $departments = Department::all();

        return view('admin.Department.AssignNurse', compact('nurses', 'departments', 'admin'));
    }


    public function storeAssignNurse(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'nurse_id' => 'required|exists:nurses,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Find the nurse and assign the department using a pivot table
        $nurse = Nurse::find($validated['nurse_id']);
        $nurse->departments()->syncWithoutDetaching($validated['department_id']);  // Add department without removing existing ones

        return redirect()->route('department_details', ['id' => $validated['department_id']])
        ->with('success', 'Nurse has been assigned to the department.');
    }

    public function assignTriageNurse()
    {
        $admin = auth()->guard('admin')->user();

        // Fetch doctors and departments to display in the form
        $triage_nurses = TriageNurse::all();
        $departments = Department::all();

        return view('admin.Department.AssignTriageNurse', compact('triage_nurses', 'departments', 'admin'));
    }


    public function storeAssignTriageNurse(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'triage_nurse_id' => 'required|exists:triage_nurses,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Find the nurse and assign the department using a pivot table
        $triagenurse = TriageNurse::find($validated['triage_nurse_id']);
        $triagenurse->departments()->syncWithoutDetaching($validated['department_id']);  // Add department without removing existing ones

        return redirect()->route('department_details', ['id' => $validated['department_id']])
        ->with('success', 'Triage Nurse has been assigned to the department.');
    }


    public function removeDoctorFromDepartment(Request $request, $departmentId, $doctorId)
    {
        $department = Department::findOrFail($departmentId);
        $doctor = Doctor::findOrFail($doctorId);
        
        // Detach the doctor from the department
        $department->doctors()->detach($doctor);

        return redirect()->back()->with('success', 'Doctor removed from department successfully.');
    }


    public function removeNurseFromDepartment(Request $request, $departmentId, $nurseId)
    {
        $department = Department::findOrFail($departmentId);
        $nurse = Nurse::findOrFail($nurseId);
        
        // Detach the nurse from the department
        $department->nurses()->detach($nurse);

        return redirect()->back()->with('success', 'Nurse removed from department successfully.');
    }
    

    public function removeTriageNurseFromDepartment(Request $request, $departmentId, $triagenurseId)
    {
        $department = Department::findOrFail($departmentId);
        $triagenurse = TriageNurse::findOrFail($triagenurseId);
        
        // Detach the nurse from the department
        $department->triage_nurse()->detach($triagenurse);

        return redirect()->back()->with('success', 'Triage Nurse removed from department successfully.');
    }











    
    public function deleteUser($userType, $id)
{
    // Determine the correct model based on the userType
    switch ($userType) {
        case 'patient':
            $model = Patient::findOrFail($id);
            
            // Retrieve all related QR codes
            $qrCodes = $model->qr_codes; // For PatientQrCode
            $recordQRCodes = $model->record_qr_codes; // For RecordQrCode
            $orderQRCodes = $model->order_qr_codes; // For OrderQrCode
            
            break;
        case 'doctor':
            $model = Doctor::findOrFail($id);
            break;
        case 'nurse':
            $model = Nurse::findOrFail($id);
            break;
        case 'triage_nurse':
            $model = TriageNurse::findOrFail($id);
            break;
        case 'admin':
            $model = Admin::findOrFail($id);
            break;
        case 'department':
            $model = Department::findOrFail($id);
            break;
        default:
            return redirect()->back()->with('error', 'Invalid user type.');
    }

    // Delete the user
    $model->delete();

    // If the user type is patient, delete the associated QR code images from storage
    if ($userType === 'patient') {
        foreach ($qrCodes as $qrCode) {
            if ($qrCode->file_path) {
                Storage::delete($qrCode->file_path);
            }
        }

        foreach ($recordQRCodes as $recordQrCode) {
            if ($recordQrCode->file_path) {
                Storage::delete($recordQrCode->file_path);
            }
        }

        foreach ($orderQRCodes as $orderQrCode) {
            if ($orderQrCode->file_path) {
                Storage::delete($orderQrCode->file_path);
            }
        }
    }

    // Redirect back with success message
    return redirect()->back()->with('success', ucfirst($userType) . ' deleted successfully');
}








    /////////////////////////////////// Emergency Room

    public function emergencyrooms(Request $request) 
    {
        $admin = auth()->guard('admin')->user();
        
        // Get the search query from the request
        $search = $request->input('search');

        // Query nurses based on the search input
        $emergencyrooms = EmergencyRoom::where(function($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            }
        })->get();
        
        // Pass the emergencyrooms and admin to the view
        return view('admin.EmergencyRoom.EmergencyRoom', compact('emergencyrooms', 'admin'));
    }


    public function EmergencyRoomRegister(){
        $admin = auth()->guard('admin')->user();
        return view('admin.EmergencyRoom.Add', compact('admin'));
    }


    public function EmergencyRoomPostRegistration(Request $request): RedirectResponse
    {  
        $request->validate([
        'email' => 'required|email|unique:emergency_rooms,email',
    ]);

    $token = Str::random(32);

    $temporaryUser = TemporaryUser::create([
        'email' => $request->get('email'),
        'registration_token' => $token,
    ]);

    // Send registration confirmation email with link including token
    Mail::send('email.emergency_room_registration_link', ['email' => $temporaryUser->email, 'token' => $token], function($message) use ($temporaryUser) {
        $message->to($temporaryUser->email)->subject('Complete Your Registration');
    });

    return redirect('admin/dashboard')->withSuccess('A confirmation email has been sent to your address.');
    }


















    /////////////////////////////////////// profile

    public function profile($id){
        // Retrieve the admin using the provided ID
        $admin = Admin::with('profile')->find($id);
    
            return view('admin.profile.profile', compact('admin'));
        }
    
        public function changepass($id){
            // Retrieve the admin using the provided ID
            $admin = Admin::find($id);
    
        
            return view('admin.profile.changepass', compact('admin'));
            }
    
        public function admin_submitpass(Request $request){
    
                // Validate the request
            $request->validate([
                'current_password' => 'required',
                'new_password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            ]);
    
            // Get the user using the custom 'admin' guard
            $user = Auth::guard('admin')->user();
    
            // Check if the current password matches
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'The provided current password does not match our records.');
            }
    
            // Update the password
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            // Optionally, log the user out of other sessions
            Auth::guard('admin')->logoutOtherDevices($request->new_password);
    
            // Redirect with success message
            return redirect()->back()->with('success', 'Your password has been changed successfully.');
        }
    
        public function changeinfo($id){
            // Retrieve the admin using the provided ID
            $admin = Admin::find($id);
    
        
            return view('admin.profile.changeinfo', compact('admin'));
            }
    
        public function admin_submitinfo(Request $request){
    
            // Validate the request
            $request->validate([
                'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
                'telephone_no' => 'required|string|max:15', // Adjust the validation rules as needed
            ]);
    
            // Get the authenticated user
            $user = Auth::guard('admin')->user();
    
            // Update the user’s email
            $user->email = $request->input('email');
            $user->save();
    
            // Update the user's profile (assuming there is a related profile model)
            $profile = $user->profile;
            $profile->telephone_no = $request->input('telephone_no');
            $profile->save();
    
            // Redirect with a success message
            return redirect()->back()->with('success', 'Your information has been updated successfully.');
        }
    
        public function admin_submitemergencyinfo(Request $request){
    
                // Validate the request data
            $request->validate([
                'emergency_email' => 'required|email|unique:profiles,emergency_email',
                'emergency_telephone_no' => 'required|string|max:15',
            ]);
    
            // Get the authenticated user
            $user = Auth::guard('admin')->user();
    
            // Find the profile or create a new one with the correct admin_id
            $emergencyContact = $user->profile()->firstOrNew(['admin_id' => $user->id]);
    
            // Update the emergency contact information
            $emergencyContact->emergency_email = $request->input('emergency_email');
            $emergencyContact->emergency_telephone_no = $request->input('emergency_telephone_no');
            // Attempt to save the emergency contact information
        if ($emergencyContact->save()) {
            // If successful, redirect with a success message
            return redirect()->back()->with('success', 'Emergency contact information has been updated successfully.');
        } else {
            // If save fails, redirect with an error message
            return redirect()->back()->with('error', 'There was an error updating your emergency contact information. Please try again.');
        }
        }
    
        public function showSessions($id)
    {
        // Retrieve the admin using the provided ID
        $admin = Admin::find($id);
    
    
        $user = Auth::guard('admin')->user();
        $sessions = $user->sessions()->orderBy('last_active_at', 'desc')->get();
        return view('admin.profile.sessions', compact('sessions', 'admin'));
    
        
    }

}









