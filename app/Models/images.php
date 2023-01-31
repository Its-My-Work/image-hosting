<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class images extends Model
{
    use HasFactory;

    static function show() {
        if(Auth::user()->role == 'admin') return images::all();
        else return images::all()->where('added_by', Auth::user()->id);
    }
}
