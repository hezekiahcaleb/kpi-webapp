<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function storeSession(Request $request){
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        $creds = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $valid = auth()->attempt($creds);

        if($valid){
            if($remember){
                Cookie::queue('email', $email, 120);
                Cookie::queue('password', $password, 120);
            }

            $request->session()->regenerate();

            return redirect()->intended('/home');
        }

        return back()->with('loginError', 'Incorrect username or password.');
    }

    public function destroySession(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function insertUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'role' => 'required'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->password = bcrypt('password');
        $user->save();

        session()->flash('message', 'User successfully added!');
        return redirect()->back();
    }

    public function updateUser(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $user = User::find($id);
        if($user!=null){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role;
            $user->save();

            session()->flash('message', 'User successfully updated!');
        }

        return redirect()->back();
    }

    public function deleteUser($id){
        $user = User::find($id);

        if($user!=null){
            $user->delete();

            session()->flash('message', 'User successfully deleted!');
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function personalDataPage(){
        return view('personaldata');
    }

    public function updatePersonalData(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back();
    }

    public function updatePasswordPage(){
        return view('updatepassword');
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'oldpassword' => 'required|current_password',
            'newpassword' => 'required|confirmed'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $user = User::find(auth()->user()->id);
        if(Hash::check($request->oldpassword, $user->password)){
            if($request->newpassword === $request->newpassword_confirmation){
                $user->password = bcrypt($request->newpassword);
                $user->save();
            } else{
                return back()->withErrors('Confirm password incorrect!');
            }
        } else{
            return back()->withErrors('Old password incorrect!');
        }

        return redirect()->back();
    }

    public function resetPassword($id){

    }
}
