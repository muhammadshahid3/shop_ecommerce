<?php

namespace App\Http\Controllers\backend\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class loginController extends Controller
{
    // Display login 
    public function login()
    {
        $shop_name['name'] = 'Shop';
        $title = 'shop/admin/login';
        return view('backend.login.login',['Shop_Name' => $shop_name , 'title' => $title]);
    }
    // Check  Admin Login
    public function checklogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|digits:6'
        ]);
        $match_data = auth()->guard('admins')->attempt(['email' => $request->email, 'password' => $request->password]);
        if ($match_data) {
            return redirect('admin/dashboard');
        } else {
            session()->flash('msg', 'Incorect Credentials');
            return redirect('admin/login');
        }
    }

    //Logout
    public function logout()
    {
        auth()->guard('admins')->logout();
        return redirect('admin/login');
    }
}
