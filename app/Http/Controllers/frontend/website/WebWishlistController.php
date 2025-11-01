<?php

namespace App\Http\Controllers\frontend\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebWishlistController extends Controller
{
    //Show Wishlist 

    public function ShowWishlist()
    {
        $array_pass = header_helper('Wishlist');
        // Frontend Changes form Admin side
        $cms_text  =  EditContent();
        if(isset($cms_text) && count($cms_text) > 0){
            $array_pass['cms_texts'] = $cms_text;
        }
        return view('frontend.wishlist.wishlist', $array_pass);
    }
}
