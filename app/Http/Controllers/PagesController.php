<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $pagetitle = "Welcome";
        return view('pages.index')->with('pagetitle',$pagetitle);
    }

    public function about(){
        return view('pages.about');
    }

    public function services(){
        $data = array(
            'title'=>'Services',
            'services'=>['Web Development','QA','SEO']
            );
        return view('pages.services')->with($data);
    }
}
