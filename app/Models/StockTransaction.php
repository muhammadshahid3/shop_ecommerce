<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    protected $table= "stock_transactions";

    protected $primarykey= "id";

    protected $guarded= [];

    
}
