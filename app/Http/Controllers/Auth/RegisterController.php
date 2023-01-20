<?php

namespace App\Http\Controllers\Auth;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //в данной функции отменяем авто вход после добавления пользователя
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return redirect()->route('register');
    }

    public function showRegistrationForm() {
        
        $user = auth()->user();
        $users = users::all();
        $user_data['name'] = 'name';
        $user_data['email'] = 'email';
        if($user['role'] == 'admin'){
            if(!$users->isEmpty()) {
                return view('auth.register', ['users' => $users, 'action' => 'register', 'user_data' => $user_data]);
            }
            else $message = "No users";
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
                return redirect()->route('register');
            }
            return redirect()->route('register');
        }
        else echo "Permission Denied";
        
    }

    //функция редактирования пользователя
    public function edit_user(Request $request, $user_id)
    {
        if ($request->isMethod('post')) {
            //проверяем допустимость файла и записываем ошибку если не допустим
            $hashed = Hash::make($request['password']);
            users::where('id', $user_id)
            ->update(['name' => $request['name'], 'email' => $request['email'], 'password' => $hashed, 'role' => $request['role']]);
        }
        $user = auth()->user();
        if($user['role'] == 'admin') {
            $users = users::all();
            $edit = users::where('id',$user_id)->first();
            if ($edit != null) {
                return view('auth.register', ['user_data' => $edit, 'users' => $users, 'action' => 'edit']);
            }
            return redirect()->route('register');
        }

        return redirect()->route('home');
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required|in:user,admin']

        ]);
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }
}
