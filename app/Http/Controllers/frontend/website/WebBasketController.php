<?php

namespace App\Http\Controllers\frontend\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Validator;
use Exception;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\GeneralSetting;

class WebBasketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:customers');
    }
    // Show Basket //
    public function ShowBasket()
    {
        try{
        // header data //
        $array_pass = header_helper('Basket');
        // Frontend Changes form Admin side
        $cms_text  = EditContent();
        if(isset($cms_text) && count($cms_text) > 0){
        $array_pass['cms_texts'] = $cms_text;
        }
        return view('frontend.basket.basket', $array_pass);
        }catch(Exception $e){
            dd($e->getMessage());
        }
     
    }
    

    
}
