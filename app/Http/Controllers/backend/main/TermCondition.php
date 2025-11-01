<?php

namespace App\Http\Controllers\backend\main;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermCondition extends Controller
{
    //Term |Condition
    public function PrivacyPolicy()
    {
        $term_Condition = DB::table('store_texts')->first();
        return view('backend.termscondition.terms_condition',['TermCondition' => $term_Condition]);
    }

    // Update Term Condition
    public function UpdatePrivacyPolicy(Request $request , $id)
    {
       DB::table('store_texts')->update(['value'=>$request->termcondition]);
       session()->flash('msg','Update Terms&Conditins Successfully');
        return redirect('admin/privacy-policy');
        
    }
}
