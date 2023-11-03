<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        return view('index');
    }

    public function dashboardPage(){
        return view('dashboard');
    }

    public function manageFormPage(){
        return view('manageform');
    }

    public function inputDataPage(){
        return view('inputdata');
    }

    public function profilePage(){
        return view('profile');
    }
}
