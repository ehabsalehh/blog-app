<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title= "hello index";
        return view('pages.index',compact("title"));
    }
    public function about(){
        $data = "hello about";
        return view("pages.about")->with("title",$data);
    }
    public function services(){
        $data = [
            "title" => "hello services",
            "services" => ["web Design" ,"Programing" ,"SEO"]];
        return view("pages.services")->with($data);
    }
}
