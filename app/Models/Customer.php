<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Contact;
class Customer extends Model
{
    use HasFactory;
    protected $table = "customers";

    protected $primarykey = "id";

    protected $guarded = [];

    // Relation with Contact us
    // public function messages()
    // {
    //     return $this->hasMany(Contact::class, 'customer_id', 'id');
    // }
}
