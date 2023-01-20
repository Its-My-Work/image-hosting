<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use DateTime;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\images;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //стартовые переменные
        $message =  __('You are logged in!');
        $images = [];
        $filename = false;
        $errors = false;

        $galleris = images::all();
        

        // если форма с файлами отправлена
        if ($request->isMethod('post') && $request->file('images')) {
            //проверяем допустимость файла и записываем ошибку если не допустим
            $request->validate([
                'images.*' => 'image',
                'images.*' => 'mimetypes:image/jpeg,image/png',
            ]); 
            if($errors == true) $message = __('Only images!');

            //проверяем кол-во файлов, если ок - загружаем
            if(count($request->file('images')) <= 5) {
                foreach($request->file('images') as $key => $image){                   
                    $upload = Storage::putFile("/public/", $image);  //загружаем файл
                    $filename .= basename($upload).'!';
                }
                
                //запрос в БД insert
                $id = DB::table('images')->insertGetId(['file' => $filename, 'upload_by' => Auth::user()->id, 'created_at' => new DateTime]);
                //сообщение об успешной загрузке
                $message = __('Image successful upload!').' '.__('Your Link:');
                $message .= "<br>".url('/')."/?id=".$id;
            }
            else $message = __('Too many images!');
            
        }
        return view('home', ['message' => $message, 'galleries' => $galleris]);
    }

    protected function delete($gallery_id)
    {
        $user = auth()->user();
        if($user['role'] == 'admin') {
            $delete = images::where('id',$gallery_id)->first();
            if ($delete != null) {
                $delete->delete();
                return redirect()->route('home');
            }
            return redirect()->route('home');
        }
        else echo "Permission Denied";
        
    }

}
