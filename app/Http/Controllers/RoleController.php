<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function insertRole(Request $request){
        $validator = Validator::make($request->all(), [
            'rolename' => 'required|unique:roles,role_name',
            'parent' => 'required'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $role = new Role();
        $role->role_name = $request->rolename;
        $role->parent_id = ($request->parent == '0') ? null : $request->parent;
        $role->form_permission = isset($request->formpermission) ? 1 : 0;
        $role->save();

        session()->flash('message', 'Role successfully added!');
        return redirect()->back();
    }

    public function updateRole(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'rolename' => 'required|unique:roles,role_name,'.$id,
            'parent' => 'required'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $role = Role::find($id);
        if($role != null){
            $role->role_name = $request->rolename;
            $role->parent_id = ($request->parent == '0') ? null : $request->parent;
            $role->form_permission = isset($request->formpermission) ? 1 : 0;
            $role->save();

            session()->flash('message', 'Role successfully updated!');
        }

        return redirect()->back();
    }

    public function deleteRole($id){
        $role = Role::find($id);

        if($role!=null){
            $users = User::where('role_id', $id)->get();
            foreach($users as $user){
                $user->role_id = 1;
                $user->save();
            }

            $role->delete();
            session()->flash('message', 'Role successfully deleted!');
            return redirect()->back();
        }

        session()->flash('message', "Role doesn't exist!");
        return redirect()->back();
    }
}
