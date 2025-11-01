<?php

namespace App\Http\Controllers\frontend\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\GeneralSetting;

class CustomerLoginController extends Controller
{
    // Customer display Login
    public function Login()
    {
        $array_pass = array();
         // Frontend Changes form Admin side
         $cms_text  =  EditContent();
         if(isset($cms_text) && count($cms_text) > 0){
             $array_pass['cms_texts'] = $cms_text;
         }
        $generalsetting = GeneralSetting::first();
        $array_pass['generalsetting'] = $generalsetting;

        if (isset($generalsetting) && isset($generalsetting->shop_name)) {
            $array_pass['page_title'] = $generalsetting->shop_name.' | Customer Login';
        } else {
            $array_pass['page_title'] = 'Shop | Customer Login';
        }

        return view('frontend.auth.login', $array_pass);
    }


    // Customer Check Login
    public function CheckLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        
        $match_data = auth()->guard('customers')->attempt(['email' => $request->email, 'password' => $request->password]);
        if ($match_data) {
            session()->flash('icon', 'success');
            session()->flash('msg', 'Successfully Login');
            return redirect()->route('website');
        } else {
            session()->flash('icon', 'error');
            session()->flash('msg', 'Invalid Credentials');
            return redirect('customer/login');
        }
    }


    // Customer Display Register
    public function Register()
    {
        $array_pass = array();
        $generalsetting = GeneralSetting::first();
        $array_pass['generalsetting'] = $generalsetting;

        if (isset($generalsetting) && isset($generalsetting->shop_name)) {
            $array_pass['page_title'] = $generalsetting->shop_name.' | Customer Login';
        } else {
            $array_pass['page_title'] = 'Shop | Customer Login';
        }

        return view('frontend.auth.register', $array_pass);
    }


    // Customer Register store 
    public function RegisterStore(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6',
            'phone_number' => 'required|numeric|unique:customers|min:11,max:12'
        ]);

        //  Password Encrpyt
        $password = bcrypt($request->password);
        $customer_create = Customer::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'phone_number' => $request->phone_number
        ]);

        if ($customer_create) {
            session()->flash('icon', 'success');
            session()->flash('msg', 'Customer Register Successfully!');
            return redirect('customer/login');
        } else {
            session()->flash('icon', 'error');
            session()->flash('msg', 'Customer not Registered!');
            return redirect()->back();
        }
    }


    //Logout
    public function Logout()
    {
        auth()->guard('customers')->logout();
        return redirect('customer/login');
    }

}
