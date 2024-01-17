<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Form;
use App\Models\FormMapping;
use App\Models\FormDetail;
use App\Models\KpiResult;

class PageController extends Controller
{
    public $systemRoleId = [1, 2];

    public function loginPage(){
        return view('login');
    }

    public function index(){
        return view('index');
    }

    public function dashboardPage(){
        $yearRange = [date("Y"), 2010];
        $kpiResult = KpiResult::where('user_id', auth()->user()->id)->orderBy('period', 'DESC')->get();

        if($kpiResult->isEmpty()){
            return view('dashboard')->with('kpiResult', [])->with('latestKpi', [])->with('yearRange', $yearRange);
        }
        $latestKpi = $kpiResult->first();
        $evaluation = '';
        if($latestKpi->score >= 0 && $latestKpi->score < 75){
            $evaluation = 'Need Improvement';
        } else if($latestKpi->score >= 75 && $latestKpi->score < 100){
            $evaluation = 'Below Expectation';
        } else if($latestKpi->score >= 100 && $latestKpi->score < 125){
            $evaluation = 'Meet Expectation';
        } else if($latestKpi->score >= 125 && $latestKpi->score <= 150){
            $evaluation = 'Above Expectation';
        } else {
            $evaluation = 'Data Invalid';
        }

        $latestKpiData = [
            'score' => $latestKpi->score,
            'evaluation' => $evaluation
        ];

        return view('dashboard')->with('kpiResult', $kpiResult)->with('latestKpi', $latestKpiData)->with('yearRange', $yearRange);
    }

    public function manageRolePage(){
        $data = Role::all()->except($this->systemRoleId)->toQuery()->paginate(10);
        $currentPage = $data->currentPage();
        $addRoleForm = view('addrole')->render();
        return view('managerole')->with('data', $data)->with('currentPage', $currentPage)->with('addRoleForm', $addRoleForm);
    }

    public function addRolePage(){
        $roles = Role::all()->except($this->systemRoleId);

        return view('addrole')->with('type', 'add')->with('roleList', $roles);
    }

    public function editRolePage($id){
        $roles = Role::all()->except($this->systemRoleId);
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
        $roles = Role::all()->except($this->systemRoleId);

        return view('adduser')->with('type', 'add')->with('roleList', $roles);
    }

    public function editUserPage($id){
        $user = User::find($id);
        $roles = Role::all()->except($this->systemRoleId);

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
        $roles = Role::all()->except($this->systemRoleId);

        return view('addform')->with('type', 'add')->with('roles', $roles)->with('formDetailData', []);
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

    public function approveDataPage(){
        $kpiResults = KpiResult::where('is_approved', 0)->where('');

        return view('approvedata')->with('data', $kpiResults);
    }

    public function profilePage(){
        return view('profile');
    }
}
