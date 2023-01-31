<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\users;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showRegistrationForm() {
        $users = users::all();
        
        if(auth()->user()->role == 'admin'){
            if(!$users->isEmpty()) {
                return view('register', ['users' => $users]);
            }
            else $message = __('main.No users');
        }
        else return redirect()->route('home');
    }

    //функция удаления пользователя
    public function delete_user($user_id)
    {
        $user = auth()->user();
        if($user['role'] == 'admin') {
            $delete = users::where('id',$user_id)->first();
            if ($delete != null) {
                $delete->delete();
                return redirect('register')->with('status', __('main.UserDelete'));
            }
            else return redirect('register')->withErrors(__('main.UserNotFound'));
        }
        else return redirect('home')->withErrors(__('main.Access Denied'));
        
    }

    //функция редактирования пользователя
    public function edit_user(Request $request, $user_id)
    {
        if(auth()->user()->role == 'admin' and $user_id == true) {
            if ($request->isMethod('post')) {
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user_id],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'role' => ['required', 'in:user,admin'],

                ]);
                $hashed = Hash::make($request['password']);
                users::where('id', $user_id)
                ->update(['name' => $request['name'], 'email' => $request['email'], 'password' => $hashed, 'role' => $request['role']]);
                return redirect('register')->with('status', __('main.UserUpdated'));
            }
            $edit = users::where('id',$user_id)->first();
            if ($edit != null) return view('register', ['user_data' => $edit, 'users' => users::all()]);
        }
        return redirect('home')->withErrors(__('main.Access Denied'));
    }

    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(request $data)
    {
        $data->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:user,admin'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect('register')->with('status', __('main.UserAdded')); 
    }
}
