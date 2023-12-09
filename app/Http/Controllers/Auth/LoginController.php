<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\View\View;

use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/home');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/home');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    } 

    public function forgotPassword()
    {
        return view('auth.forgot');
    }

    public function ResetPasswordMail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!empty($user)){
            $user->remember_token = Str::random(40);
            $user->save();


            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->withSuccess('A password reset link has been sent to your email address.');

        }
        else{
            return redirect()->back()->withErrors(['email' => 'The provided email does not exist.']);
        }
    }

    public function ResetForm(){

        $user = User::where('remember_token', request()->route('token'))->first();
        if(!empty($user)){
            return view('auth.reset', ['user' => $user]);
        }
        else{
            return redirect()->route('login')->withErrors(['email' => 'The provided email does not exist.']);
        }
    }

    public function ResetPassword(Request $request){

        $request->validate([
            'password' => ['required', 'confirmed'],
        ]);
        
        $user = User::where('remember_token', $request->token)->first();
        if(!empty($user)){
            
            $user->password = Hash::make($request->password);
            $user->remember_token = null;
            $user->save();
            return redirect()->route('login')->withSuccess('Password reset successfully!');
        }
        
    }
}
