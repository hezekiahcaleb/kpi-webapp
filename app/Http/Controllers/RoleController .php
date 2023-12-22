<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;

class RoleController extends Controller
{
    public function index(){
        return view('index');
    }

    public function dashboardPage(){
        return view('dashboard');
    }

    public function manageFormPage(){
        $data = Form::paginate(10);
        $currentPage = $data->currentPage();
        return view('manageform')->with('data', $data)->with('currentPage', $currentPage);
    }

    public function addFormPage(){
        return view('addform');
    }

    public function inputDataPage(){
        return view('inputdata');
    }

    public function profilePage(){
        return view('profile');
    }
}
