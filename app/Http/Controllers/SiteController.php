<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiteController extends Controller
{
    public function create(){
        return view('site.create');
    }

    public function show($name,$age,$image_id){
        $site = Site::where('name',$name)->where('age',$age)->first();
        $image = Image::where('id',$image_id)->first();
        if(!isset($site) || !isset($image)){
            return abort(404);
        }
        return view('site.show', compact('site'));
    }
}
