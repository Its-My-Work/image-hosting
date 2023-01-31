<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Route;
use App\Models\User;
use App\Models\password_resets;


class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /*
     * Where to redirect users after resetting their password.
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    public $token;
   

    function reset_link_form() {
        return view('reset');
    }

    function reset_link_send(Request $request) {
        $request->validate(['email' => ['required', 'string', 'email', 'max:255'],]);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
 
        return $status === Password::RESET_LINK_SENT
                    ? redirect()->route('password.reset_link')->with('status',__($status))
                    : redirect()->route('password.reset_link')->withErrors(__($status));
    }

    function change_password (Request $request) {

        $request->validate([
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
            'email' => 'required|email|min:8',
            'reset_token' => 'required|min:8'
        ]);

        
        $check = password_resets::firstWhere('email', $request['email']);
        if (Hash::check($request['reset_token'], $check['token'])) {
            $user = User::where('email', $request['email'])->first();
            $user->password = Hash::make($request['password']);
            if($user->save() == true) return redirect('login')->with('status', __('main.reset_success'));
            else return redirect('login')->withErrors( __('auth.reset_failed'));

        }
        else return redirect('login')->withErrors( __('main.reset_failed'));

    }
}
