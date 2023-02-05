<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;



class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showRegistrationForm() {
        $users = User::paginate(10);
        if(auth()->user()->role == 'admin'){
            if(!$users->isEmpty()) {
                return view('register', ['users' => $users]);
            }
            else $message = __('main.No users');
        }
        else return redirect()->route('home');
    }

    //функция удаления пользователя
    public function delete_user(request $user)
    {
        if(auth()->user()->role == 'admin') {
            $delete = user::where('id',$user['id'])->first();
            if ($delete != null) {
                $delete->delete();
                return redirect('users')->with('status', __('main.UserDelete'));
            }
            else return redirect('users')->withErrors(__('main.UserNotFound'));
        }
        else return redirect('home')->withErrors(__('main.Access Denied'));
        
    }

    //функция редактирования пользователя
    public function edit_user(Request $request, $user_id)
    {
        if(auth()->user()->role == 'admin' and $user_id == true) {
            if ($request->isMethod('post')) {
                if($request['password_checkbox'] == true) {
                    $request->validate([
                        'name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user_id],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required', 'in:user,admin'],
                    ]);
                    $hashed = Hash::make($request['password']);
                user::where('id', $user_id)
                ->update(['name' => $request['name'], 'email' => $request['email'], 'password' => $hashed, 'role' => $request['role']]);
                }
                else {
                    $request->validate([
                        'name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user_id],
                        'role' => ['required', 'in:user,admin'],
                    ]);
                    $hashed = Hash::make($request['password']);
                user::where('id', $user_id)
                ->update(['name' => $request['name'], 'email' => $request['email'], 'role' => $request['role']]);
                }
                
                return redirect('users')->with('status', __('main.UserUpdated'));
            }
            $edit = user::where('id',$user_id)->first();
            if ($edit != null) return view('register', ['user_data' => $edit, 'users' => User::paginate(10)]);
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

        return redirect('users')->with('status', __('main.UserAdded')); 
    }
}
