<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientRecord;
use App\Models\Record;
use App\Models\Doctor;
use App\Models\EmergencyRoom;
use App\Models\Department;
use App\Models\Nurse;
use App\Models\TreatmentPlan;
use App\Models\erOrder;
use App\Models\Order;
use App\Models\Test;
use App\Models\erOrderQRcode;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EmergencyRoomController extends Controller
{

    public function dashboard(Request $request) 
    {
        $eroom = auth()->guard('eroom')->user();
        // Fetch the latest 5 notifications
        $latestNotifications = auth('eroom')->user()->notifications()->latest()->take(5)->get();
        // Count older notifications
        $olderNotifications = auth('eroom')->user()->notifications()->latest()->skip(5)->take(20)->get();

        // Get the search query and status filter from the request
        $search = $request->input('search');
        $status = $request->input('status', 'pending'); // Default to 'pending'

        // Query all patients and filter by status and search
        $patients = Patient::where(function($query) use ($status, $search) {
            if ($status) {
                $query->where('status', $status); // Filter by status ('admitted' or 'pending')
            }
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%') // Search by name or email
                    ->orWhere('email', 'like', '%' . $search . '%');
            }
        })->get();

        // Pass the filtered patients and status to the view
        return view('emergencyroom.dashboard', compact('patients', 'status', 'eroom', 'latestNotifications', 'olderNotifications'));
    }



    public function MedicalOrders(Request $request) 
    {
        $eroom = auth()->guard('eroom')->user();
        // Fetch the latest 5 notifications
        $latestNotifications = auth('eroom')->user()->notifications()->latest()->take(5)->get();
        // Count older notifications
        $olderNotifications = auth('eroom')->user()->notifications()->latest()->skip(5)->take(20)->get();

        // Get the search query and status filter from the request
        $search = $request->input('search');
        $status = $request->input('status', 'pending'); // Default to 'pending'

        // Query all patients and filter by status and search
        $patients = Patient::where(function($query) use ($status, $search) {
            if ($status) {
                $query->where('status', $status); // Filter by status ('admitted' or 'pending')
            }
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%') // Search by name or email
                    ->orWhere('email', 'like', '%' . $search . '%');
            }
        })->get();

        // Pass the filtered patients and status to the view
        return view('emergencyroom.medicalOrder', compact('patients', 'status', 'eroom', 'latestNotifications', 'olderNotifications'));

    }

    public function ScanQR(){
    // Retrieve the patient using the provided ID
    $eroom = auth()->guard('eroom')->user();
    // Fetch the latest 5 notifications
    $latestNotifications = auth('eroom')->user()->notifications()->latest()->take(5)->get();
    // Count older notifications
    $olderNotifications = auth('eroom')->user()->notifications()->latest()->skip(5)->take(20)->get();

        return view('emergencyroom.ScanQR', compact('eroom', 'latestNotifications', 'olderNotifications'));
    }

    public function Details($id, $notification_id = null)
    { 
        $eroom = Auth::guard('eroom')->user();
        // Retrieve the patient using the provided ID
        $patient = Patient::with('patientrecord')->find($id);
    // Fetch the latest 5 notifications
        $latestNotifications = auth('eroom')->user()->notifications()->latest()->take(5)->get();
        // Count older notifications
        $olderNotifications = auth('eroom')->user()->notifications()->latest()->skip(5)->take(20)->get();
        // Check if the patient exists
        if (!$patient) {
            return redirect()->back()->withErrors(['message' => 'Patient not found.']);
        }

        $notification = auth('eroom')->user()->notifications()->find($notification_id);
        // Check if the notification exists and if it has not been read
        if ($notification) {
            if (!$notification->read_at) {
                $notification->markAsRead();
                \Log::info('Notification marked as read', ['notification_id' => $notification_id]);
            } else {
                \Log::info('Notification was already read', ['notification_id' => $notification_id]);
            }
        } else {
            \Log::info('Notification not found', ['notification_id' => $notification_id]);
        }

        // Pass the patient data to the view
        return view('emergencyroom.Details', compact('patient', 'eroom', 'latestNotifications', 'olderNotifications'));
    }

    public function AddOrder($id)
    {
    $eroom = auth()->guard('eroom')->user();
    // Retrieve the patient using the provided ID
    $patient = Patient::with('patientrecord')->find($id);
    // Fetch the latest 5 notifications
    $latestNotifications = auth('eroom')->user()->notifications()->latest()->take(5)->get();
    // Count older notifications
    $olderNotifications = auth('eroom')->user()->notifications()->latest()->skip(5)->take(20)->get();

    // Check if the patient exists
    if (!$patient) {
        return redirect()->back()->withErrors(['message' => 'Patient not found.']);
    }


        // Pass the patient data to the view
        return view('emergencyroom.AddOrder', compact('patient', 'eroom', 'latestNotifications', 'olderNotifications'));
    }

    public function OrderPage($id)
    {
        $eroom = auth()->guard('eroom')->user();
    // Retrieve the patient using the provided ID
    $patient = erOrder::with(['patientRecord', 'order_qrcode'])->find($id);
    // Fetch the latest 5 notifications
    $latestNotifications = auth('eroom')->user()->notifications()->latest()->take(5)->get();
    // Count older notifications
    $olderNotifications = auth('eroom')->user()->notifications()->latest()->skip(5)->take(20)->get();

    // Pass the patient data to the view
    return view('emergencyroom.OrderPage', compact('patient', 'eroom', 'latestNotifications', 'olderNotifications'));
    }

    public function AddMedicalOrder($id)
    {
        $eroom = auth()->guard('eroom')->user();
        // Retrieve the patient using the provided ID
        $patientRecord = PatientRecord::find($id);
        $departments = Department::all();
        $doctors = Doctor::all(); // Retrieve all doctors
        $nurses = Nurse::all();   // Retrieve all nurses

        // Fetch the latest 5 notifications
        $latestNotifications = auth('eroom')->user()->notifications()->latest()->take(5)->get();
        // Count older notifications
        $olderNotifications = auth('eroom')->user()->notifications()->latest()->skip(5)->take(20)->get();
        
        // Check if the patient exists
        if (!$patientRecord) {
            return redirect()->back()->withErrors(['message' => 'Patient not found.']);
        }

        // Pass the patient data to the view
        return view('emergencyroom.AddMedicalOrder', compact('patientRecord', 'doctors', 'nurses', 'eroom', 'departments', 'latestNotifications', 'olderNotifications'));
    }

    public function storeOrder(Request $request, $patientId)

        {
        DB::beginTransaction();

        try { 


        $patientRecord = PatientRecord::findOrFail($patientId);
        $eroom = Auth::guard('eroom')->user();

        // Create the Order record
        $order = erOrder::create([
            'patient_id' => $patientRecord->patient_id,
            'doctor_id' => $patientRecord->doctor_id,
            'nurse_id' => $patientRecord->nurse_id,
            'department_id' => $request->admitting_department,
            'patient_record_id' => $patientRecord->id,
            'emergency_room_id' => $eroom->id,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status,
            'order_date' => $request->order_date,
            'title' => $request->title,
        ]);

        DB::commit();

        $patientRecord->step_status = "ER";
        $patientRecord->save();

        // Fetch the patient record to generate QR code
        $order = erOrder::with(['patientRecord', 'order_qrcode'])->findOrFail($order->id);


        // Call the generateQRCode method
        $this->generateQRCode($order);

            return redirect()->route('emergencyroom_dashboard')->with('success', 'Medical Order created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error message and stack trace
            \Log::error('Error creating profile: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->route('emergencyroom_dashboard')->with('error', 'There was an error creating the Medical Order: ' . $e->getMessage());
        }
        
        
        }

        public function generateQRCode(erOrder $order)
        {
            // Generate the URL that the QR code will point to
            $url = route('erOrder.show', $order->id);
        
            // Generate the QR code as a PNG image pointing to the URL
            $qrCodeImage = QrCode::format('png')->size(200)->generate($url);
        
            // Define a unique file path where the QR code image will be stored in the S3 bucket
            $uniqueId = Str::uuid(); // Generate a unique ID
            $filePath = 'erOrderQRcodes/' . $order->id . '_' . $uniqueId . '.png';
        
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
        
            // Store the file path in the database, associating it with the order
            erOrderQrCode::create([
                'patient_record_id' => $order->patient_record_id,
                'er_order_id' => $order->id,
                'file_path' => $filePath,
                'patient_id' => $order->patient_id,
            ]);
        }
        

        public function showQR(erOrder $order)
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
            return view('emergencyroom.show', compact('order'));
        }


    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }


    public function showOrder($id)
    {
    $department = auth()->guard('department')->user();
    // Retrieve the patient using the provided ID
    $patient = Order::find($id);

    // Check if the patient exists
    if (!$patient) {
        return redirect()->back()->withErrors(['message' => 'Order not found.']);
    }

    // Pass the patient data to the view
    return view('department.showOrder', compact('patient', 'department'));
    }


    public function showDoctorProfile($id)
    {
        $department = auth()->guard('department')->user();
        $doctor = Doctor::with('departments')->findOrFail($id);

        // Get the status filter from the request
        $status = request('status', 'admitted');

        // Fetch patients that the doctor has managed, filtered by status
        $patients = Patient::whereHas('patientrecord', function($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })
        ->where('status', $status) // Filter by patient status
        ->get();

        return view('department.DoctorProfile', compact('department', 'doctor', 'patients'));
    }


    public function showNurseProfile($id)
    {
        $department = auth()->guard('department')->user();
        $nurse = Nurse::with('departments')->findOrFail($id);

        // Get the status filter from the request
        $status = request('status', 'admitted');

        // Fetch patients that the nurse has managed, filtered by status
        $patients = Patient::whereHas('patientrecord', function($query) use ($nurse) {
            $query->where('nurse_id', $nurse->id);
        })
        ->where('status', $status) // Filter by patient status
        ->get();

        return view('department.NurseProfile', compact('department', 'nurse', 'patients'));
    }


    public function showTriageProfile($id)
    {
        $department = auth()->guard('department')->user();
        $triagenurse = TriageNurse::with('departments')->findOrFail($id);

        

        return view('department.TriageNurseProfile', compact('department', 'triagenurse'));
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










    /////////////////////////// profile

    public function profile($id){
    // Retrieve the patient using the provided ID
    $eroom = EmergencyRoom::find($id);

        return view('emergencyroom.profile.profile', compact('eroom'));
    }


    public function changepass($id){
    // Retrieve the patient using the provided ID
    $eroom = EmergencyRoom::find($id);


    return view('emergencyroom.profile.changepass', compact('eroom'));
    }


    public function department_submitpass(Request $request){

        // Validate the request
    $request->validate([
        'current_password' => 'required',
        'new_password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
    ]);
    
    // Get the user using the custom 'department' guard
    $user = Auth::guard('eroom')->user();
    
    // Check if the current password matches
    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->with('error', 'The provided current password does not match our records.');
    }
    
    // Update the password
    $user->password = Hash::make($request->new_password);
    $user->save();
    
    // Optionally, log the user out of other sessions
    Auth::guard('eroom')->logoutOtherDevices($request->new_password);
    
    // Redirect with success message
    return redirect()->back()->with('success', 'Your password has been changed successfully.');
    }
    
    
    public function showSessions($id)
    {
    // Retrieve the department using the provided ID
    $eroom = EmergencyRoom::find($id);
    
    
    $user = Auth::guard('eroom')->user();
    $sessions = $user->sessions()->orderBy('last_active_at', 'desc')->get();
    return view('emergencyroom.profile.sessions', compact('sessions', 'eroom'));   
    }
}
