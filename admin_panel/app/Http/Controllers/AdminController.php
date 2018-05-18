<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class AdminController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post'))
        {
            $data = $request->input();
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])){
                //Session::put('adminSession',$data['email']);
                return redirect('admin/dashboard');
            }else{
                return redirect('admin')->with('falsh_massage_error', 'Invalid Email or Password!');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard(){
        /*if(Session::has('adminSession')){
            //Perform all dashboard tasks
        }else{
            return redirect('admin')->with('falsh_massage_error', 'Please login to access');
        }*/
        return view('admin.dashboard');
    }

    public function settings(){
        return view('admin.settings');
    }

    public function logout(){
        Session::flush();
        return redirect('admin')->with('falsh_massage_success', 'Logout Success!');
    }
}
