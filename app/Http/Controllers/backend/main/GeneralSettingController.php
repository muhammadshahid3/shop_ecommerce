<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;

class GeneralSettingController extends Controller
{
    //Settings
    public function index()
    {
        $array_pass = array();
        $array_pass['generalsetting'] = GeneralSetting::first();

        return view('backend.settings.setting', $array_pass);
    }

    public function store(Request $request)
    {
       
        $generalsetting = GeneralSetting::first();

        $request->validate(['shop_name' => 'required|string']);
        if ($request->shop_name) {
            $shop_name = $request->shop_name;
        } else {
            $shop_name = NULL;
        }
      
        if ($request->email) {
            $request->validate(['email' => 'email']);
            $email = $request->email;
        } else {
            $email = NULL;
        }
    
        if ($request->contact) {
            $request->validate(['contact' => 'numeric|digits:11']);
            $contact = $request->contact;
        } else {
            $contact = NULL;
        }

        if ($request->address) {
            $request->validate(['address' => 'string']);
            $address = $request->address;
        } else {
            $address = NULL;
        }
    
        if ($request->description) {
            $request->validate(['description' => 'string']);
            $description = $request->description;
        } else {
            $description = NULL;
        }
    
        if ($request->facebook) {
            $request->validate(['facebook' => 'string']);
            $facebook = $request->facebook;
        } else {
            $facebook = NULL;
        }

        if ($request->instagram) {
            $request->validate(['instagram' => 'string']);
            $instagram = $request->instagram;
        } else {
            $instagram = NULL;
        }

        if ($request->twitter) {
            $request->validate(['twitter' => 'string']);
            $twitter = $request->twitter;
        } else {
            $twitter = NULL;
        }

        if ($request->shop_logo) {
            
            $request->validate(['shop_logo' => 'image|mimes:jpeg,png,jpg,svg,gif|max:2048']);
            // remove pre-exists image //
            if (isset($generalsetting->shop_logo)) {
                if (file_exists(public_path('upload/website/') . $generalsetting->shop_logo)) {
                    unlink(public_path('upload/website/') . $generalsetting->shop_logo);
                }
            }

            // upload image //
            $filename = time().uniqid().'.'.$request->shop_logo->getClientOriginalExtension(); 
            $request->shop_logo->move(public_path('upload/website/'), $filename);

        } else {
            $filename = $generalsetting->shop_logo;
        }

        // Discount value validation check

        if($request->discount_value ){

            $request->validate(['discount_value' => 'numeric|regex:/^[0-9]*$/']);

                $discount_value = $request->discount_value;
        }else{
                 $discount_value = Null;
        }

         // Shipping Charges validation check

        if($request->shipping_charges ){

            $request->validate(['shipping_charges' => 'numeric|regex:/^[0-9]*$/']);

                $shipping_charges = $request->shipping_charges;
        }else{
                 $shipping_charges = Null;
        }


        if (isset($generalsetting)) {
            $id = $generalsetting->id;
            $save = GeneralSetting::where('id', $id)->update([
                'shop_name'                => $shop_name,
                'email'                    => $email,
                'contact'                  => $contact,
                'address'                  => $address,
                'notification'             => $request->notification ? $request->notification : 'A',
                'status'                   => $request->status ? $request->status : 'A',
                'description'              => $description,
                'shop_logo'                => $filename,
                'facebook'                 => $facebook,
                'instagram'                => $instagram,
                'twitter'                  => $twitter,
                'order_collection_type'    => ($request->order_collection_type ) ? $request->order_collection_type :  'N',
                'order_delivery_type'      => ($request->order_delivery_type ) ? $request->order_delivery_type :  'N',
                'discount_value'           => $discount_value,
                'discount_type'            => ($request->discount_price ) ? $request->discount_price :  'N',
                'shipping_charges'         =>  $shipping_charges,
                'shipping_status'          => ($request->Flat) ? $request->Flat : 'N',
                'beep_status'              => ($request->Beepsound) ? $request->Beepsound : 'I',
                'pay_by_card'              => ($request->pay_by_card ) ? $request->pay_by_card :  'I',
                'pay_by_cash'              => ($request->cash_on_delivery) ? $request->cash_on_delivery : 'I',

            ]);

        } else{
            $save = GeneralSetting::create([
                'shop_name'                => $shop_name,
                'email'                    => $email,
                'contact'                  => $contact,
                'address'                  => $address,
                'notification'             => $request->notification ? $request->notification : 'A',
                'status'                   => $request->status ? $request->status : 'A',
                'description'              => $description,
                'shop_logo'                => $filename,
                'facebook'                 => $facebook,
                'instagram'                => $instagram,
                'twitter'                  => $twitter,
                'order_collection_type'    => $request->order_collection_type,
                'order_delivery_type'      => $request->order_delivery_type ,
                'discount_value'           => $request->discount_value ,
                'discount_type'            => $request->discount_type ,
                'shipping_charges'         => $request->shipping_charges ,
                'shipping_status'          => $request->Flat,
                'beep_status'              => $request->Beepsound,
                'pay_by_card'              => $request->pay_by_card ,
                'pay_by_cash'              => $request->pay_by_cash,

                
            ]);
        }
    
        if ($save) {

            // delete old cache of general_settings and add new cache //
            caches_general_settings_helper($reset_caches=TRUE);
            
            session()->flash('msg', 'Setting save successfully');
        } else {
            session()->flash('msg', 'Unable to update setting');
        }
        return redirect()->route('admin.setting');
    }
}
