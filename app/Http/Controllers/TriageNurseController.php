<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\TriageNurse;
use App\Models\ChargeNurse;
use App\Models\BedControl;
use App\Models\Department;
use App\Models\TemporaryUser;
use App\Models\Admission;
use App\Models\Test;
use App\Models\Vital;
use App\Models\Profile;
use App\Models\PatientQrCode;
use App\Models\PatientRecord;
use App\Models\PhysicalAssessment;
use App\Models\Record;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use Hash;
use Auth;
use Mail;



class TriageNurseController extends Controller
{
    public function dashboard(Request $request)
        {
            $triagenurse = Auth::guard('triagenurse')->user();
            
            // Get the search query and status filter from the request
            $search = $request->input('search');
            $status = $request->input('status', 'pending'); // Default to 'admitted'

            // Query patients and filter by status and search if provided
            $patients = Patient::where(function($query) use ($status, $search) {
                if ($status) {
                    $query->where('status', $status); // Filter by status ('admitted' or 'pending')
                }
                if ($search) {
                    $query->where(function($subQuery) use ($search) {
                        $subQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                    });
                }
            })->get();
            
            // Pass the filtered patients, status, and triagenurse data to the view
            return view('triagenurse.Patient', compact('patients', 'status', 'triagenurse'));
        }


    

    public function AddPatient($id)
        {
            $triagenurse = Auth::guard('triagenurse')->user();
            // Retrieve the patient using the provided ID
            $patient = Patient::find($id);
            $doctors = Doctor::all(); // Retrieve all doctors
            $nurses = Nurse::all();   // Retrieve all nurses
            $departments = Department::all();

            // Check if the patient exists
            if (!$patient) {
                return redirect()->back()->withErrors(['message' => 'Patient not found.']);
            }

            // Pass the patient data to the view
            return view('triagenurse.AddPatient', compact('patient', 'doctors', 'nurses', 'triagenurse', 'departments'));
        }


    public function Details($id)
        { 
            $triagenurse = Auth::guard('triagenurse')->user();
            // Retrieve the patient using the provided ID
            $patient = Patient::with('patientrecord')->find($id);

            // Check if the patient exists
            if (!$patient) {
                return redirect()->back()->withErrors(['message' => 'Patient not found.']);
            }

            // Pass the patient data to the view
            return view('triagenurse.Details', compact('patient', 'triagenurse'));
        }

    public function Profile($id)
        {
            $triagenurse = Auth::guard('triagenurse')->user();
            // Retrieve the patient using the provided ID
            $patient = Patient::with('patientrecord.profile')->find($id);

            // Check if the patient exists
            if (!$patient) {
                return redirect()->back()->withErrors(['message' => 'Patient not found.']);
            }

            // Pass the patient data to the view
            return view('triagenurse.Profile', compact('patient'. 'triagenurse'));
        }

    public function PatientRecord($id)
        {
            $triagenurse = Auth::guard('triagenurse')->user();
            // Retrieve the patient using the provided ID
            $patient = PatientRecord::with(['profile', 'vital', 'admission', 'test', 'patient', 'record', 'qrcode'])->find($id);
            

            // Pass the patient data to the view
            return view('triagenurse.PatientRecord', compact('patient' ,'triagenurse'));
        }

    public function Record($id)
        {
        $triagenurse = Auth::guard('triagenurse')->user();
        // Retrieve the patient using the provided ID
        $patient = Record::with(['vital', 'test', 'patient', 'patientRecord', 'physical_assessment', 'record_qrcode'])->find($id);
        

        // Pass the patient data to the view
        return view('triagenurse.record', compact('patient', 'triagenurse'));
        }

    public function storeProfile(Request $request, $id)
        {

            $profile = Profile::create([
                'patient_id' => $id,
                'name' => $request->name,
                'age' => $request->age,
                'birthday' => $request->birthday,
                'birthplace' => $request->birthplace,
                'civil_status' => $request->civil_status,
                'gender' => $request->gender,
                'telephone_no' => $request->telephone_no,
            ]);
                return redirect()->route('login')->with('success', 'Profile created successfully.');
            
        }

    public function storeData(Request $request, $patientId)
        {
            DB::beginTransaction();

            try { 

            // Create the profile record
            $profile = Profile::where('patient_id', $patientId)->firstOrFail();

            $test = Test::create([
                'patient_id' => $patientId,
                'hpi' => $request->hpi,
                'note' => $request->note,
                'medication' => $request->medication,
                'chief_complaint' => $request->chief_complaint,
                'diagnose' => $request->diagnose,
            ]);
            
            $vital = Vital::create([
                'patient_id' => $patientId,
                'body_temperature' => $request->body_temperature,
                'blood_pressure' => $request->blood_pressure,
                'respiratory_rate' => $request->respiratory_rate,
                'weight' => $request->weight,
                'height' => $request->height,
                'pulse_rate' => $request->pulse_rate,
            ]);
            
            $admission = Admission::create([
                'patient_id' => $patientId,
                'room' => $request->room,
                'doctor_id' => $request->attending_physician,
                'nurse_id' => $request->attending_nurse,
                'department_id' => $request->admitting_department,
            ]);
            
            $triageNurseId = Auth::guard('triagenurse')->user();

            // Create the patient record
            $patientRecord = PatientRecord::create([
                'patient_id' => $patientId,
                'doctor_id' => $request->attending_physician,
                'nurse_id' => $request->attending_nurse,
                'triage_nurse_id' => $triageNurseId->id,
                'profile_id' => $profile->id,
                'test_id' => $test->id,
                'vital_id' => $vital->id,
                'admission_id' => $admission->id,
                'reason_for_admission' => $request->reason_for_admission,
                'admitting_date_and_time' => $request->admitting_date_and_time,
            ]);
            
            DB::commit();

            $patientRecord->step_status = "Triage";
            $patientRecord->save();

            // Fetch the patient record to generate QR code
            $patientRecord = PatientRecord::with(['profile', 'test', 'vital', 'admission', 'qrcode'])->findOrFail($patientRecord->id);


            // Call the generateQRCode method
            $this->generateQRCode($patientRecord);

                return redirect()->route('triagenurse_dashboard')->with('success', 'Admission created successfully.');

            } catch (\Exception $e) {
                DB::rollBack();
                // Log the error message and stack trace
                \Log::error('Error creating profile: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
                return redirect()->route('triagenurse_dashboard')->with('error', 'There was an error creating the profile: ' . $e->getMessage());
            }
            
            
        }


        public function generateQRCode(PatientRecord $patientRecord)
        {
            // Generate the URL that the QR code will point to
            $url = route('patientRecord.show', $patientRecord->id);

            // Generate the QR code as a PNG image pointing to the URL
            $qrCodeImage = QrCode::format('png')->size(200)->generate($url);

            // Define a unique file path where the QR code image will be stored in the S3 bucket
            $uniqueId = Str::uuid(); // Generate a unique ID
            $filePath = 'PatientQRcodes/' . $patientRecord->id . '_' . $uniqueId . '.png';

            // Attempt to save the QR code image to the S3 storage
            try {
                Storage::disk('s3')->put($filePath, $qrCodeImage);
                
                // Log successful upload
                \Log::info('QR code uploaded successfully to S3 at: ' . $filePath);
            } catch (\Exception $e) {
                // Log any errors that occur during upload
                \Log::error('Error uploading QR code to S3: ' . $e->getMessage() . "\nTrace: " . $e->getTraceAsString());
            }

            if (Storage::disk('s3')->exists($filePath)) {
                \Log::info('QR code exists on S3 at: ' . $filePath);
            } else {
                \Log::error('QR code does not exist on S3 at: ' . $filePath);
            }

            // Store the file path in the database
            PatientQrCode::create([
                'patient_record_id' => $patientRecord->id,
                'file_path' => $filePath,
                'patient_id' => $patientRecord->patient_id,
                'qr_code_type' => 'admission',
            ]);
        }

        

    public function showQR(PatientRecord $patientRecord)
        {
            // Get the currently authenticated user's guard
            $userGuard = null;
        
            if (auth()->guard('triagenurse')->check()) {
                $userGuard = 'triagenurse';
            } elseif (auth()->guard('doctor')->check()) {
                $userGuard = 'doctor';
            } elseif (auth()->guard('nurse')->check()) {
                $userGuard = 'nurse';
            } elseif (auth()->guard('patient')->check()) {
                $userGuard = 'patient';
            } elseif (auth()->guard('department')->check()) {
                $userGuard = 'department';
            } elseif (auth()->guard('eroom')->check()) {
                $userGuard = 'eroom';
            }
        
            // If no valid guard is found, deny access
            if (!$userGuard) {
                return redirect()->route('login')->with('error', 'Unauthorized Access');
            }

            // If authorized, show the QR code details
            return view('triagenurse.show', compact('patientRecord'));
        }













        ///////////////// profile

        public function triage_profile($id){
            // Retrieve the triagenurse using the provided ID
            $triagenurse = TriageNurse::with('profile')->find($id);
        
                return view('triagenurse.profile.profile', compact('triagenurse'));
            }
        
            public function changepass($id){
                // Retrieve the triagenurse using the provided ID
                $triagenurse = TriageNurse::find($id);
        
            
                return view('triagenurse.profile.changepass', compact('triagenurse'));
                }
        
            public function triagenurse_submitpass(Request $request){
        
                    // Validate the request
                $request->validate([
                    'current_password' => 'required',
                    'new_password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
                ]);
        
                // Get the user using the custom 'triagenurse' guard
                $user = Auth::guard('triagenurse')->user();
        
                // Check if the current password matches
                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->back()->with('error', 'The provided current password does not match our records.');
                }
        
                // Update the password
                $user->password = Hash::make($request->new_password);
                $user->save();
        
                // Optionally, log the user out of other sessions
                Auth::guard('triagenurse')->logoutOtherDevices($request->new_password);
        
                // Redirect with success message
                return redirect()->back()->with('success', 'Your password has been changed successfully.');
            }
        
            public function changeinfo($id){
                // Retrieve the triagenurse using the provided ID
                $triagenurse = TriageNurse::find($id);
        
            
                return view('triagenurse.profile.changeinfo', compact('triagenurse'));
                }
        
            public function triagenurse_submitinfo(Request $request){
        
                // Validate the request
                $request->validate([
                    'email' => 'required|email|unique:triage_nurses,email,' . Auth::guard('triagenurse')->id(),
                    'telephone_no' => 'required|string|max:15', // Adjust the validation rules as needed
                ]);
        
                // Get the authenticated user
                $user = Auth::guard('triagenurse')->user();
        
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
        
            public function triagenurse_submitemergencyinfo(Request $request){
        
                    // Validate the request data
                $request->validate([
                    'emergency_email' => 'required|email|unique:profiles,emergency_email',
                    'emergency_telephone_no' => 'required|string|max:15',
                ]);
        
                // Get the authenticated user
                $user = Auth::guard('triagenurse')->user();
        
                // Find the profile or create a new one with the correct triagenurse_id
                $emergencyContact = $user->profile()->firstOrNew(['triagenurse_id' => $user->id]);
        
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
            // Retrieve the triagenurse using the provided ID
            $triagenurse = TriageNurse::find($id);
        
        
            $user = Auth::guard('triagenurse')->user();
            $sessions = $user->sessions()->orderBy('last_active_at', 'desc')->get();
            return view('triagenurse.profile.sessions', compact('sessions', 'triagenurse'));
        
            
        }













        ////Add Patient 

        public function PatientRegister(){
            $triagenurse = auth()->guard('triagenurse')->user();
    
            return view('triagenurse.Patients.Add', compact('triagenurse'));
        }
    
        public function patientPostRegistration(Request $request): RedirectResponse
        {  
            $request->validate([
            'email' => 'required|email|unique:patients',
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
    
        return redirect('triagenurse/dashboard')->withSuccess('A confirmation email has been sent to your address.');
        }
}
