<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    // 
    public function Dashboard()
    {
        $array_pass = array();

        $generalsetting = DB::table('general_settings')->first();
        $array_pass['generalsetting'] = $generalsetting;

        $array_pass['customer_count'] =  Customer::count();
        $array_pass['category_count'] =  Category::count();
        $array_pass['product_count']  =  Product::count();
        $array_pass['order_count']  =  Order::count();

        return view('backend.dashboard.dashboard',$array_pass);
    }

}
