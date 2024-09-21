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

    public function show($id,$name){
        $site = Site::where('name',$name)->where('id',$id)->first();
        if(!isset($site)){
            return abort(404);
        }
        return view('site.show', compact('site'));
    }

}
