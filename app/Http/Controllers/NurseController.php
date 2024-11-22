<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\PhysicalAssessment;
use App\Models\PatientRecord;
use App\Models\PatientQrCode;
use App\Models\Profile;
use App\Models\Test;
use App\Models\Vital;
use App\Models\Record;
use App\Models\RecordQrCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Hash;
use Auth;
use Illuminate\Validation\ValidationException;

class NurseController extends Controller
{
    public function dashboard()
        {
            // Specify the 'nurse' guard to get the logged-in nurse
            $nurse = auth()->guard('nurse')->user(); 

            // Get all patient records assigned to this nurse, excluding discharged patients
            $patientRecords = $nurse->patientRecords()
                                    ->with('patient')
                                    ->whereHas('patient', function ($query) {
                                        $query->where('status', '!=', 'discharged');
                                    })
                                    ->get()
                                    ->unique('patient_id');

            return view('nurse.dashboard', compact('patientRecords', 'nurse'));
        }


    public function Details($id)
        {
            $nurse = auth()->guard('nurse')->user();
            // Retrieve the patient using the provided ID
            $patient = Patient::with('patientrecord')->find($id);

            // Check if the patient exists
            if (!$patient) {
                return redirect()->back()->withErrors(['message' => 'Patient not found.']);
            }

            // Pass the patient data to the view
            return view('nurse.Details', compact('patient', 'nurse'));
        }

    public function PatientRecord($id)
        {
        $nurse = auth()->guard('nurse')->user();
        // Retrieve the patient using the provided ID
        $patient = PatientRecord::with(['profile', 'vital', 'admission', 'test', 'patient', 'record', 'qrcode'])->find($id);
        

        // Pass the patient data to the view
        return view('nurse.PatientRecord', compact('patient', 'nurse'));
        }

    public function Record($id)
        {
        $nurse = auth()->guard('nurse')->user();
        // Retrieve the patient using the provided ID
        $patient = Record::with(['vital', 'test', 'patient', 'patientRecord', 'physical_assessment', 'record_qrcode'])->find($id);
        

        // Pass the patient data to the view
        return view('nurse.record', compact('patient', 'nurse'));
        }


    public function AddPatient($id)
        {
        $nurse = auth()->guard('nurse')->user();
        // Retrieve the patient using the provided ID
        $patient = Patient::with('patientrecord')->find($id);

        // Check if the patient exists
        if (!$patient) {
            return redirect()->back()->withErrors(['message' => 'Patient not found.']);
        }


            // Pass the patient data to the view
            return view('nurse.AddPatient', compact('patient', 'nurse'));
        }

    public function AddChart($id)
        {
            $nurse = auth()->guard('nurse')->user();
            // Retrieve the patient using the provided ID
            $patientRecord = PatientRecord::find($id);

            $doctors = Doctor::all(); // Retrieve all doctors
            $nurses = Nurse::all();   // Retrieve all nurses

            // Check if the patient exists
            if (!$patientRecord) {
                return redirect()->back()->withErrors(['message' => 'Patient not found.']);
            }

            // Pass the patient data to the view
            return view('nurse.AddChart', compact('patientRecord', 'doctors', 'nurses', 'nurse'));
        }

        public function showPatientCharts() {

            $nurse = auth()->guard('nurse')->user();

            $patients = Record::with(['patient', 'vital' => function($query) {
                $query->latest(); // Load vitals in descending order
            }])->where('nurse_id', $nurse->id)->get();
        
            return view('nurse.PatientCharts', compact('patients', 'nurse'));
        }
        
        

    public function storeData(Request $request, $patientId)

        {
        DB::beginTransaction();

        try { 


        $patientRecord = PatientRecord::findOrFail($patientId);

        // Get the currently authenticated nurse (assuming the guard is 'nurse' or 'triagenurse')
        $currentNurseId = Auth::guard('nurse')->id();


        $vital = Vital::create([
            'patient_id' => $patientRecord->patient_id,
            'body_temperature' => $request->body_temperature,
            'blood_pressure' => $request->blood_pressure,
            'respiratory_rate' => $request->respiratory_rate,
            'weight' => $request->weight,
            'height' => $request->height,
            'pulse_rate' => $request->pulse_rate,
        ]);

        // Create the patient record
        $physicalassessment = PhysicalAssessment::create([
            'patient_id' => $patientRecord->patient_id,
            'general_appearance' => $request->general_appearance,
            'pain_assessment' => $request->pain_assessment,
            'pain_description' => $request->pain_description,
            'changes_in_condition' => $request->changes_in_condition,
            'assessment_date' => $request->assessment_date,
            'nurse_id' => $currentNurseId,
        ]);
        

        // Create the patient record
        $record = Record::create([
            'patient_id' => $patientRecord->patient_id,
            'doctor_id' => $patientRecord->doctor_id,
            'nurse_id' => $currentNurseId,
            'patient_record_id' => $patientRecord->id,
            'vital_id' => $vital->id,
            'physical_assessment_id' => $physicalassessment->id,
            'rounds' => $request->rounds,
            'admitting_date_and_time' => $physicalassessment->assessment_date,
        ]);

        DB::commit();

        // Fetch the patient record to generate QR code
        $record = Record::with(['test', 'vital', 'physical_assessment', 'patientRecord', 'record_qrcode'])->findOrFail($record->id);


        // Call the generateQRCode method
        $this->generateQRCode($record);

            return redirect()->route('nurse_dashboard')->with('success', 'Chart created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error message and stack trace
            \Log::error('Error creating profile: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->route('nurse_dashboard')->with('error', 'There was an error creating the chart: ' . $e->getMessage());
        }
        
        
        }


            public function generateQRCode(Record $record)
        {
            // Generate the URL that the QR code will point to
            $url = route('Record.show', $record->id);
        
            // Generate the QR code as a PNG image pointing to the URL
            $qrCodeImage = QrCode::format('png')->size(200)->generate($url);
        
            // Define a unique file path where the QR code image will be stored in the S3 bucket
            $uniqueId = Str::uuid(); // Generate a unique ID
            $filePath = 'RecordQRcodes/' . $record->id . '_' . $uniqueId . '.png';
        
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
        
            // Store the file path in the database, associating it with the record
            RecordQrCode::create([
                'patient_record_id' => $record->patient_record_id,
                'record_id' => $record->id,
                'file_path' => $filePath,
                'patient_id' => $record->patient_id,
            ]);
        }
        

        public function showQR(Record $record)
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
            return view('nurse.show', compact('record'));
        }
        




        /////////////////// profile

        public function profile($id){
            // Retrieve the nurse using the provided ID
            $nurse = Nurse::with('profile')->find($id);
        
                return view('nurse.profile.profile', compact('nurse'));
            }
        
            public function changepass($id){
                // Retrieve the nurse using the provided ID
                $nurse = Nurse::find($id);
        
            
                return view('nurse.profile.changepass', compact('nurse'));
                }
        
        public function nurse_submitpass(Request $request){
        
                    // Validate the request
                $request->validate([
                    'current_password' => 'required',
                    'new_password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
                ]);
        
                // Get the user using the custom 'nurse' guard
                $user = Auth::guard('nurse')->user();
        
                // Check if the current password matches
                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->back()->with('error', 'The provided current password does not match our records.');
                }
        
                // Update the password
                $user->password = Hash::make($request->new_password);
                $user->save();
        
                // Optionally, log the user out of other sessions
                Auth::guard('nurse')->logoutOtherDevices($request->new_password);
        
                // Redirect with success message
                return redirect()->back()->with('success', 'Your password has been changed successfully.');
            }
        
        public function changeinfo($id){
                // Retrieve the nurse using the provided ID
                $nurse = Nurse::find($id);
        
            
                return view('nurse.profile.changeinfo', compact('nurse'));
                }
        
        public function nurse_submitinfo(Request $request){
        
                // Validate the request
                $request->validate([
                    'email' => 'required|email|unique:nurses,email,' . Auth::guard('nurse')->id(),
                    'telephone_no' => 'required|string|max:15', // Adjust the validation rules as needed
                ]);
        
                // Get the authenticated user
                $user = Auth::guard('nurse')->user();
        
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
        
        public function nurse_submitemergencyinfo(Request $request){
        
                    // Validate the request data
                $request->validate([
                    'emergency_email' => 'required|email|unique:profiles,emergency_email',
                    'emergency_telephone_no' => 'required|string|max:15',
                ]);
        
                // Get the authenticated user
                $user = Auth::guard('nurse')->user();
        
                // Find the profile or create a new one with the correct nurse_id
                $emergencyContact = $user->profile()->firstOrNew(['nurse_id' => $user->id]);
        
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
            // Retrieve the nurse using the provided ID
            $nurse = Nurse::find($id);
        
        
            $user = Auth::guard('nurse')->user();
            $sessions = $user->sessions()->orderBy('last_active_at', 'desc')->get();
            return view('nurse.profile.sessions', compact('sessions', 'nurse'));
        
            
            }


}
