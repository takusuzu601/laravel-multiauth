<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function check(Request $request){
        // Validate
        $request->validate([
            'email'=>'required|exists:admins,email',
            'password'=>'required|min:5|max:30'
        ],[
            'email.exists'=>'This email is not exists in admins table'
        ]);

        // $request->only(A,B)  A,Bのみ取得する
        $creds=$request->only('email','password');

        if (Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('admin.login')->with('fail','Incorrect credentials');
        }
        
    }

    function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
