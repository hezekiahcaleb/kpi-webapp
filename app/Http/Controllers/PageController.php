<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Form;
use App\Models\FormMapping;
use App\Models\FormDetail;

class PageController extends Controller
{
    public function loginPage(){
        return view('login');
    }

    public function index(){
        return view('index');
    }

    public function dashboardPage(){
        return view('dashboard');
    }

    public function manageRolePage(){
        $data = Role::paginate(10);
        $currentPage = $data->currentPage();
        $addRoleForm = view('addrole')->render();
        return view('managerole')->with('data', $data)->with('currentPage', $currentPage)->with('addRoleForm', $addRoleForm);
    }

    public function addRolePage(){
        $roles = Role::all();

        return view('addrole')->with('type', 'add')->with('roleList', $roles);
    }

    public function editRolePage($id){
        $roles = Role::all();
        $roleData = Role::find($id);

        $roles = $roles->reject(function($item) use ($roleData){
            return $item == $roleData;
        });

        if($roleData!=null){
            return view('addrole')->with('type', 'update')->with('roleList', $roles)->with('roleData', $roleData);
        }

        return redirect()->back();
    }

    public function manageUserPage(){
        $data = User::paginate(10);
        $currentPage = $data->currentPage();
        return view('manageuser')->with('data', $data)->with('currentPage', $currentPage);
    }

    public function addUserPage(){
        $roles = Role::all();

        return view('adduser')->with('type', 'add')->with('roleList', $roles);
    }

    public function editUserPage($id){
        $user = User::find($id);
        $roles = Role::all();

        if($user!=null){
            return view('adduser')->with('type', 'update')->with('user', $user)->with('roleList', $roles);
        }

        return redirect()->back();
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
        $role = auth()->user()->role;
        $forms = $role->forms;

        return view('inputdata')->with('forms', $forms);
    }

    public function inputDataFormPage($id){
        $form = Form::find($id);

        return view('inputdataform')->with('form', $form);
    }

    public function profilePage(){
        return view('profile');
    }
}
