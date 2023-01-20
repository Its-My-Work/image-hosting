<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;


class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $id)
    {
        $images = false;
        $message = false;
        $user_id = Auth::user()?->id;
        if($user_id) {
            $menu = "<a class='btn btn-primary' href=". route('home') .">Home</a>";
            $menu .= "<form id='logout-form' action=".  route('logout') ." method='POST' class='d-none'>
                    @csrf
                </form><a class='btn btn-primary' href=". route('logout') ." onclick='event.preventDefault(); document.getElementById('logout-form').submit()'>Logout</a>";
        }
        else $menu = "<a class='btn btn-primary' href=". route('login') .">Login</a>";
        

        if($id->input('id') == TRUE) {
            $images = images::where('id', $id->input('id'))->get();
            if(!$images->isEmpty()) {
                foreach($images as $key => $image){
                    $files = explode('!', $image['file']);
                    unset($files[count($files)-1]);
                    foreach($files as $file) {
                        $message .= "<a href='/storage/". $file ."'><img src='/storage/". $file."' class='galery'></a>";
                    }
                }
                return view('welcome', ['message' => $message, 'menu' => $menu]);
            }
            else return view('welcome', ['message' => __('Not Found!'), 'menu' => $menu]);
        }
        else return view('welcome', ['message' => '', 'menu' => $menu]);
        
    }

}
