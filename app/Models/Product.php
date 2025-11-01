<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use App\Models\Product_images;
use App\Models\Category;
class Product extends Model
{
    use HasFactory , Searchable;
    protected $table = "products";

    protected $primarykey = "id";

    protected $guarded = [];


    // {{--RelationShip in Products--}}

    // Product Category relation
    public function Categories()
    {
        return $this->belongsTo(Category::class , 'category_id' , 'id');
    }

    // Product_images relation
    public function Product_Images()
    {
        return $this->hasMany(Product_images::class , 'product_id' , 'id');
    }

    // Product Additional Details relatio
    public function ProductAdditionalDetails(){

        return $this->hasMany(Product_Additional_Details::class , 'product_id' , 'id');
    }


    /**
 * Get the indexable data array for the model.
 *
 * @return array<string, mixed>
 */
#[SearchUsingPrefix(['id', 'product_name'])]
public function toSearchableArray(): array
{
    return [
        'id' => $this->id,
        'product_name' => $this->product_name,
       
    ];
}
}
