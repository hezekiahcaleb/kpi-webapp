<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Form;
use App\Models\FormMapping;
use App\Models\FormDetail;

class PageController extends Controller
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
        $roles = Role::all();

        return view('addform')->with('type', 'add')->with('roles', $roles);
    }

    public function editFormPage($id){
        $formData = Form::find($id);

        if($formData!=null){
            $roles = Role::all();
            $formMappingData = FormMapping::where('form_id', $id)->get();
            $formDetailData = FormDetail::where('form_id', $id)->get();
            return view('addform')->with('type', 'update')->with('formData', $formData)->with('roles', $roles)->with('formMappingData', $formMappingData)->with('formDetailData', $formDetailData);
        }

        return redirect()->back();
    }

    public function inputDataPage(){
        return view('inputdata');
    }

    public function profilePage(){
        return view('profile');
    }
}
