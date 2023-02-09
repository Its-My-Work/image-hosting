<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;
use URL;

class IndexController extends Controller
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
    public function index(Request $get)
    {
        $images = false;
        $message = false;

        if(Auth::user()?->id) {
            $menu = "<a class='btn btn-primary' href=". route('home') .">". __('main.home')."</a>";
            $menu .= "<form id='logout-form' action=".  route('logout') ." method='POST' class='d-none'>@csrf</form>";
            $menu .= "<a class='btn btn-primary' href=". route('logout') ." onclick='event.preventDefault(); document.getElementById('logout-form').submit()'>". __('main.logout')."</a>";
        }
        else $menu = "<a class='btn btn-primary' href=". route('login') .">".__('main.login')."</a>";
        

        if($get->input('gallery_id') == true) {
            $images = images::where('id', $get->input('gallery_id'))->get();
            if(!$images->isEmpty()) {
                foreach($images as $key => $image){
                    $files = explode('!', $image['file']);
                    unset($files[count($files)-1]);
                    foreach($files as $file) {
                        $message .= "<img onclick=\"BigPicture({el: this, imgSrc: '/storage/". $file."'})\" src=".URL::asset('storage/'.$file)."  class='gallery img-thumbnail'>";
                    }
                }
                return view('index', ['message' => $message, 'menu' => $menu]);
            }
            else return view('index', ['message' => __('main.GalleryNotFound'), 'menu' => $menu]);
        }
        else return view('index', ['message' => '', 'menu' => $menu]);
        
    }

}
