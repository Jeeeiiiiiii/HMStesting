<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\TriageNurse;
use App\Models\Patient;
use App\Models\PatientRecord;
use App\Models\Department;
use App\Models\EmergencyRoom;
use App\Models\Order;
use App\Models\erOrder;
use Illuminate\Support\Facades\Hash;
use App\Notifications\OrderStatusChanged;
use App\Notifications\EROrderStatusChanged;
use App\Notifications\PatientEROrderStatusChanged;
use App\Notifications\PatientOrderStatusChanged;
use Auth;

class DepartmentController extends Controller
{

    public function dashboard(Request $request) 
    {
        $department = auth()->guard('department')->user();
        
        
        // Get the search query and status filter from the request
        $search = $request->input('search');
        $status = $request->input('status', 'doctor'); // Default to 'doctor'

        // Find the specific department by ID
        $departmentId = $department->id;
        $departments = Department::findOrFail($departmentId);

        // Query doctors, nurses, or triage nurses associated with this department based on the status
        if ($status == 'doctor') {
            $staff = $departments->doctors()
                ->where(function($query) use ($search) {
                    if ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    }
                })->get();
        } elseif ($status == 'nurse') {
            $staff = $departments->nurses()
                ->where(function($query) use ($search) {
                    if ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    }
                })->get();
        } else { // Triage nurses
            $staff = $departments->triage_nurse() // Assuming you have a relationship defined
                ->where(function($query) use ($search) {
                    if ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    }
                })->get();
        }

        // Pass the filtered staff and department to the view
        return view('department.dashboard', compact('staff', 'department', 'departments', 'status'));
    }

    public function MedicalOrders(Request $request) 
    {
        $department = auth()->guard('department')->user();
        
        // Get the search query and status filter from the request
        $search = $request->input('search');
        $status = $request->input('status', 'pending'); // Default to 'pending'

        // Find the specific department by ID
        $departmentId = $department->id;
        $departments = Department::findOrFail($departmentId);

        // Get related orders based on the status
        $ordersQuery = $departments->orders(); // Get the orders relationship

        // Filter by status
        if ($status === 'completed') {
            $ordersQuery->where('status', 'completed');
        } else { // Default to 'pending'
            $ordersQuery->where('status', 'pending');
        }

        // Apply search filter if provided
        if ($search) {
            $ordersQuery->where(function($query) use ($search) {
                $query->whereHas('patient', function($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%'); // Search by patient's name
                })
                ->orWhereHas('doctor', function($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%'); // Search by doctor's name
                });
            });
        }

        $orders = $ordersQuery->get(); // Get the filtered results

        // Pass the filtered orders and department to the view
        return view('department.MedicalOrder', compact('orders', 'department', 'ordersQuery', 'status'));

    }

    public function ERMedicalOrders(Request $request) 
    {
        $department = auth()->guard('department')->user();
        
        // Get the search query and status filter from the request
        $search = $request->input('search');
        $status = $request->input('status', 'pending'); // Default to 'pending'

        // Find the specific department by ID
        $departmentId = $department->id;
        $departments = Department::findOrFail($departmentId);

        // Get related orders based on the status
        $ordersQuery = $departments->er_orders(); // Get the orders relationship

        // Filter by status
        if ($status === 'completed') {
            $ordersQuery->where('order_status', 'completed');
        } else { // Default to 'pending'
            $ordersQuery->where('order_status', 'pending');
        }

        // Apply search filter if provided
        if ($search) {
            $ordersQuery->where(function($query) use ($search) {
                $query->whereHas('patient', function($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%'); // Search by patient's name
                })
                ->orWhereHas('doctor', function($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%'); // Search by doctor's name
                });
            });
        }

        $orders = $ordersQuery->get(); // Get the filtered results

        // Pass the filtered orders and department to the view
        return view('department.ERMedicalOrder', compact('orders', 'department', 'ordersQuery', 'status'));

    }
    

    public function ScanQR(){
    // Retrieve the patient using the provided ID
    $department = auth()->guard('department')->user();

        return view('department.ScanQR', compact('department'));
    }


    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();
        $orderStatus = $order->status;

        // Notify the department user
        $department = $order->doctor; // Assuming the order has a department relationship
        $department->notify(new OrderStatusChanged($order, $orderStatus));

        // Notify the patient user
        $patient = $order->patient; // Assuming the order has a department relationship
        $patient->notify(new PatientOrderStatusChanged($order, $orderStatus));

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function updateEROrderStatus(Request $request, $id)
{
    $order = erOrder::findOrFail($id);
    $order->order_status = $request->input('status');
    $order->save();
    $orderStatus = $order->order_status;

    $record = PatientRecord::findOrFail($order->patient_record_id);
    $record->step_status = "Lab";
    $record->save();

    // Using the eroom guard to notify EmergencyRoom users
    $emergencyRoomUsers = EmergencyRoom::where('id', $order->emergency_room_id)->get();
    foreach ($emergencyRoomUsers as $user) {
        $user->notify(new EROrderStatusChanged($order, $orderStatus));
    }

    // Notify the patient user
    $patient = $order->patient; // Assuming the order has a department relationship
    $patient->notify(new PatientEROrderStatusChanged($order, $orderStatus));

    return redirect()->back()->with('success', 'Emergency Room Order status updated and notified successfully.');
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

    public function showErOrder($id)
    {
    $department = auth()->guard('department')->user();
    // Retrieve the patient using the provided ID
    $patient = erOrder::find($id);

    // Check if the patient exists
    if (!$patient) {
        return redirect()->back()->withErrors(['message' => 'Order not found.']);
    }

    // Pass the patient data to the view
    return view('department.showErOrder', compact('patient', 'department'));
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
    $department = Department::find($id);

        return view('department.profile.profile', compact('department'));
    }


    public function changepass($id){
    // Retrieve the patient using the provided ID
    $department = Department::find($id);


    return view('department.profile.changepass', compact('department'));
    }


    public function department_submitpass(Request $request){

        // Validate the request
    $request->validate([
        'current_password' => 'required',
        'new_password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
    ]);
    
    // Get the user using the custom 'department' guard
    $user = Auth::guard('department')->user();
    
    // Check if the current password matches
    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->with('error', 'The provided current password does not match our records.');
    }
    
    // Update the password
    $user->password = Hash::make($request->new_password);
    $user->save();
    
    // Optionally, log the user out of other sessions
    Auth::guard('department')->logoutOtherDevices($request->new_password);
    
    // Redirect with success message
    return redirect()->back()->with('success', 'Your password has been changed successfully.');
    }
    
    
    public function showSessions($id)
    {
    // Retrieve the department using the provided ID
    $department = Department::find($id);
    
    
    $user = Auth::guard('department')->user();
    $sessions = $user->sessions()->orderBy('last_active_at', 'desc')->get();
    return view('department.profile.sessions', compact('sessions', 'department'));   
    }
}
