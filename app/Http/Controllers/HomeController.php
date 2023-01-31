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

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($message = false)
    {
        if(Auth::user()->role == 'admin') $added_by = '*';
        $galleris = images::show();
        return view('home', ['status' => $message, 'galleries' => $galleris]);
    }

    //функция создания галереи и загрузки изображений
    protected function create(Request $request)
    {
        if ($request->isMethod('post') && $request->file('images')) {
            //проверяем допустимость файла и записываем ошибку если не допустим
            $request->validate([
                'images.*' => 'image',
                'images.*' => 'mimetypes:image/jpeg,image/png',
            ]); 

            if(count($request->file('images')) <= 5) {
                $filename = false;
                foreach($request->file('images') as $key => $image){                   
                    $upload = Storage::putFile("/public/", $image);  //загружаем файл
                    $filename .= basename($upload).'!';
                }
                //запрос в БД insert
                $id = DB::table('images')->insertGetId(['file' => $filename, 'upload_by' => Auth::user()->id, 'created_at' => new DateTime]);
                //сообщение об успешной загрузке
                $message = __('main.Image successful upload!')."<br>".__('main.Your Link:');
                $message .= " ".url('/')."/?id=".$id;
                return redirect('home')->with('status', $message);
            }
            else return redirect('home')->withErrors(__('main.Too many images!'));
            
        } 
        else  return redirect('home')->withErrors(__('main.NotSelectedImages'));
    }
    
    //функция удаления галереи
    protected function delete($gallery_id)
    {
        if(auth()->user()->role == 'admin') {
            $delete = images::where('id',$gallery_id)->first();
            if ($delete != null) $delete->delete();   
            return redirect('home')->with('status', __('main.Gallery is deleted!'));
        }
        else return redirect('home')->withErrors(__('main.Access Denied'));
        
    }

}
