<?php

namespace App\Http\Controllers\backend\main;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use Auth;

class CouponController extends Controller
{
    //All Coupons
    public function AllCoupons(Request $request)
    {
        if($request->ajax()){
            $coupon_data = Coupon::select('*');
            return DataTables::of($coupon_data)
            ->addIndexColumn()

            ->addColumn('action', function (Coupon $coupon_data) {
                $btn = '<a href="' . route('admin.coupon.editcoupon', $coupon_data->id) . '"  class="edit mx-3"><i class="fa fa-pen-alt"></i></a>';
                $btn = $btn . ' <a href="' . route('admin.coupon.deletecoupon', $coupon_data->id) . '"  class="edit" onclick="return confirm(' . "'Are you sure want to delete this record?'" . ')"><i class="fa fa-trash-alt"></i></a>';
                return $btn;
            })

            ->addColumn('coupon_status' , function (Coupon $coupon_data){

                if($coupon_data->coupon_status == 'A'){
                    return "Active";
                }else{
                    return "Inactive";
                }
            })
            ->rawColumns(['action','coupon_status'])
            ->make(true);
        }
        return view("backend.coupon.show_coupon");
    }

    // Add Coupon
    public function AddCoupon()
    {
        return view("backend.coupon.add_coupon");
    }

    // Store Coupon 
    public function StoreCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|min:8|max:8',
            'coupon_amount' => 'required|numeric|regex:/^[a-zA-Z0-9 ]*$/',
            'number_of_uses' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'limit_per_uses' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'coupon_stock' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'coupon_start_date' => 'required|date_format:Y-m-d|after:yesterday',
            'coupon_end_date' => 'required|date_format:Y-m-d|after:yesterday',
        ],['coupon_start_date.after' => 'The date format is invalid']);

        // Save Coupon data
          $insert_coupon_data = Coupon::create([
                'coupon_Code' => $request->coupon_code,
                'coupon_amount' => $request->coupon_amount,
                'number_of_uses' => $request->number_of_uses,
                'limit_per_uses' => $request->limit_per_uses,
                'coupon_stock' => $request->coupon_stock,
                'coupon_start_date' => $request->coupon_start_date,
                'coupon_end_date' => $request->coupon_end_date,
                'coupon_status' => $request->coupon_status,
        ]);

        if($insert_coupon_data){

            session()->flash('msg','Add Coupon Successfully');
            return redirect("admin/coupon/allcoupons");
        }

    }

    // Edit Coupon 
    public function EditCoupon($id)
    {
       $coupon_detail = Coupon::where('id',$id)->first();
       $arr_pass['coupon_detail'] = $coupon_detail;

       return view("backend.coupon.edit_coupon",$arr_pass);
    }

    // Update Coupon 
    public function UpdateCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|min:8|max:8',
            'coupon_amount' => 'required',
            'number_of_uses' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'limit_per_uses' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'coupon_stock' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'coupon_start_date' => 'required|date_format:Y-m-d|after:yesterday',
            'coupon_end_date' => 'required|date_format:Y-m-d|after:yesterday',
        ],['coupon_start_date.after' => 'The date format is invalid']);
 
        $update_coupon = Coupon::where('id',$request->coupon_id)->update([
            'coupon_Code' => $request->coupon_code,
            'coupon_amount' => $request->coupon_amount,
            'number_of_uses' => $request->number_of_uses,
            'limit_per_uses' => $request->limit_per_uses,
            'coupon_stock' => $request->coupon_stock,
            'coupon_start_date' => $request->coupon_start_date,
            'coupon_end_date' => $request->coupon_end_date,
            'coupon_status' => $request->coupon_status,
        ]);

        if($update_coupon){

            session()->flash('msg','Update Coupon Successfully');
            return redirect("admin/coupon/allcoupons");
        }
    }

    // Delete Coupon 
    public function DelCoupon($id)
    {
       $del_coupon = Coupon::where('id',$id)->delete();
       if($del_coupon){
        session()->flash('msg','Delete Coupon Successfully');
        return redirect("admin/coupon/allcoupons");
       }
    }

    // Coupon Code Apply
    public function CouponCode(Request $request)
    {
      $coupn_status = false;
      $response = array();
      $coupon = Coupon::where('coupon_code',$request->coupon_code)->first();
      $customer_id = auth()->guard('customers')->user()->id;
      $today_date = date('Y-m-d');
       
        if($coupon && $coupon->coupon_status == 'A'){
           
            if($today_date <= $coupon->coupon_end_date){
                
                if($coupon->coupon_stock > 0){

                    $coupon_count =  DB::table('orders')
                    ->where('coupon_id',$coupon->id)
                    ->count();
            
                    if($coupon_count < $coupon->number_of_uses){   

                        $coupn_status = true;
                    }else{

                        $coupn_status = false;
                    }
                }else{
                    $response['statuscode'] = 204;
                    $response['message'] = 'Coupon not exits';
                }
             
          
                if($coupn_status == true){
                    
                    $coupon_use_count =  DB::table('orders')
                                        ->where('customer_id',$customer_id)
                                        ->where('coupon_id',$coupon->id)
                                        ->count();

                    if($coupon_use_count < $coupon->limit_per_uses){
                      
                        $response['message'] = 'Coupon Apply Successfully';
                        $response['coupon_id'] = $coupon->id;  
                        $response['coupon_code'] = $coupon->coupon_code;  
                        $response['coupon_amount'] =  GetTwodecimalHelper($coupon->coupon_amount);
                        $response['statuscode'] = 200;
                    }
                }else{
                    $response['statuscode'] = 204;
                    $response['message'] = 'Coupon limit has completed';
                }
               
            }else{
                $response['statuscode'] = 422;
                $response['message'] = 'Coupons has expired';
            }
        }else{
            $response['statuscode'] = 422;
            $response['message'] = 'Invalid Coupon Code';
        }
        
        return response()->json($response);

    }


}
