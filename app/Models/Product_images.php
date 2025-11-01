<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_images extends Model
{
    use HasFactory;

    protected $table = "products_gallery_img";

    protected $primarykey = "id";

    protected $guarded = [];
}
