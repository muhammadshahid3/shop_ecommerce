<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Additional_Details extends Model
{
    use HasFactory;
    protected $table= "product_additional_details";

    protected $primarykey= "id";

    protected $guarded= [];
}
