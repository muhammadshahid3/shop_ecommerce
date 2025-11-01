<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;
class CmsTextController extends Controller
{
    // EditContent
    public function EditContent(Request $request)
    {
   
        $tag_value = null; 
    
        $response = [];
        // Get Single Editable Data
        try{
            $cms_text_data  =  DB::table('cms_texts')->where('tag',$request->tag_name)->first();
            // Check Header_logo
            if( $cms_text_data->tag == 'header_logo' && $request->tag_value != null){
                if($cms_text_data->value == $request->tag_value){
                    $tag_value = $request->tag_value;
                 
                }elseif($cms_text_data->tag == 'header_logo'){
                    // preview image file delete
                    if(file_exists(public_path('upload/website/').$cms_text_data->value) && $cms_text_data->value != null){
                        unlink(public_path('upload/website/').$cms_text_data->value);
                    }
                      // upload image file //
                    $img_path_64 = $request->tag_value;
                    // Get Extinction
                    $extinction = explode('/',explode(':',substr($img_path_64 , 0 , strpos($img_path_64, ';')))[1])[1];
                    $replace = substr($img_path_64 , 0 , strpos($img_path_64 , ',')+1);
                    $image = str_replace($replace, '' ,$img_path_64 );
                    $image = str_replace(' ', '+' ,$image);
                    // Image and extinction
                    $file_name =  GenerateSlug(). '.'.$extinction;
                    $tag_value = $file_name;
                    // file Path
                    $public_path = "/upload/website/".$file_name;
                    $file_path = public_path().$public_path;
                    file_put_contents($file_path , base64_decode($image)); 
                }else{
                    $tag_value = null;
                }
            }else{
                  // preview image file delete
                  if(file_exists(public_path('upload/website/').$cms_text_data->value) && $cms_text_data->value != null){
                    unlink(public_path('upload/website/').$cms_text_data->value);
                }
                   $tag_value = null;
            }

            // Check Contact
            if($cms_text_data->tag == 'header_contact' && $request->tag_name != null){
                    $tag_value = $request->tag_value;
            }
        
            // Update Record CMS Data
           
            DB::table('cms_texts')->where('tag',$request->tag_name)->update(['value' => $tag_value]);

            $response['statuscode'] = 200;

        }catch(Exeption $e){
            $message = $e->getMessage();
            var_dump($message);
        }
        // 172413579566c43973b4077.png
        return response()->json($response);
    }

    // Upload Image 

    public function SummernoteUploadImage(Request $request)
    {   
   
        $response = [];
        $response['statuscode']=  200;
        $response['logo'] = $request->logo;
        return response()->json($response);
    }
}
