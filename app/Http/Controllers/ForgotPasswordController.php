<?php 
  
namespace App\Http\Controllers; 
  
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use App\Models\Patient; 
use App\Models\Doctor; 
use App\Models\Nurse; 
use App\Models\TriageNurse; 
use App\Models\Admin; 
use App\Models\Department; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
  
class ForgotPasswordController extends Controller
{
      /**
     * Show the form for requesting a password reset link.
     *
     * @return View
     */
    public function showForgetPasswordForm(): View
    {
        return view('forgetPassword');
    }

    /**
     * Handle the form submission for the password reset request.
     *
     * @return RedirectResponse
     */
    public function submitForgetPasswordForm(Request $request): RedirectResponse
{
    $request->validate([
        'email' => 'required|email',
    ]);

    // Array of user models by guard type
    $guards = [
        'doctor' => \App\Models\Doctor::class,
        'patient' => \App\Models\Patient::class,
        'nurse' => \App\Models\Nurse::class,
        'triagenurse' => \App\Models\TriageNurse::class,
        'admin' => \App\Models\Admin::class,
        'department' => \App\Models\Department::class,
    ];

    $user = null;
    $guard = null;

    // Loop through guards to find the user
    foreach ($guards as $guardType => $model) {
        $user = $model::where('email', $request->email)->first();
        if ($user) {
            $guard = $guardType;
            break;
        }
    }

    // If no user found
    if (!$user) {
        return redirect()->route('login')->with('error', 'No user found with this email address.');
    }

    // Create the reset token
    $token = Str::random(64);

    // Insert into password resets table
    DB::table('password_resets')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => Carbon::now(),
        'guard' => $guard, // Store the guard
    ]);

    // Send reset email
    Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request) {
        $message->to($request->email);
        $message->subject('Reset Password');
    });

    return redirect()->route('login')->with('success', 'We have e-mailed your password reset link!');
}


    /**
     * Show the form for resetting the password.
     *
     * @param string $token
     * @return View
     */
    public function showResetPasswordForm($token): View
    {
        return view('forgetPasswordLink', ['token' => $token]);
    }

    /**
     * Handle the password reset form submission.
     *
     * @return RedirectResponse
     */
    public function submitResetPasswordForm(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            'password_confirmation' => 'required',
        ]);

        // Retrieve the record from password_resets using the email and token
        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return redirect()->route('login')->with('error', 'Invalid token or email!');
        }

        // Determine the guard from the reset record
        $guard = $resetRecord->guard;

        // Update the password based on the user type
        switch ($guard) {
            case 'doctor':
                $user = \App\Models\Doctor::where('email', $request->email)->first();
                break;
            case 'patient':
                $user = \App\Models\Patient::where('email', $request->email)->first();
                break;
            case 'nurse':
                $user = \App\Models\Nurse::where('email', $request->email)->first();
                break;
            case 'triagenurse':
                $user = \App\Models\TriageNurse::where('email', $request->email)->first();
                break;
            case 'admin':
                $user = \App\Models\Admin::where('email', $request->email)->first();
                break;
            case 'department':
                $user = \App\Models\Department::where('email', $request->email)->first();
                break;
        }

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete the password reset record
            DB::table('password_resets')->where('email', $request->email)->delete();

            return redirect('/login')->with('success', 'Your password has been changed!');
        }

        return back()->withInput()->with('error', 'User not found!');
    }
}