<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use App\Models\Adminlogin;
use Illuminate\Http\Request;
use Validator;

class ProfileController extends Controller
{
    // Profile
    public function Profile()
    {
        $admin_details = Adminlogin::all(); 
        return view('backend.profile.profile',compact('admin_details'));
    }

    // Update Profile
    public function UpdateProfile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|numeric|digits:11',

        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()]);
        }
        $update = Adminlogin::where('id', $request->id)->update([
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number
        ]);
        if ($update) {
             session()->flash('msg','Edit profile successfully');
            return response()->json($update);
        }
    }
}
