<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post'))
        {
            $data = $request->input();
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])){
                return redirect('admin/dashboard');
            }else{
                return redirect('admin')->with('falsh_massage_error', 'Invalid Email or Password!');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function settings(){
        return view('admin.settings');
    }
    
    public function chkPassword(Request $request){
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $check_password = User::where(['admin'=>'1'])->first();
        if(Hash::check($current_password,$check_password->password)){
            echo "true"; die;
        }else {
            echo "false"; die;
        }
    }

    public function logout(){
        Session::flush();
        return redirect('admin')->with('falsh_massage_success', 'Logout Success!');
    }
}
