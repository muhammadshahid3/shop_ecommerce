<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
class ProductRating extends Model
{
    use HasFactory;

    protected $table= "product_ratings";

    protected $primarykey= "id";

    protected $guarded= [];

    // Get  Customer Relation
     public function customers()
      {
        return $this->belongsTo(Customer::class , 'customer_id', 'id');
      }

    // Get CAtegory Relation
      public function categories()
      {
        return $this->belongsTo(Category::class , 'category_id' , 'id');
      }

      // Get Product relation
    public function products()
    {
        return $this->belongsTo(Product::class , 'product_id' , 'id');
    }

  
}
