<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customerlogin extends Authenticatable 
{
    use HasFactory,Notifiable;

    protected $table= "customers";


    protected $primarykey= "id";

    protected $guarded= [];

    // get Auth Password

    public function getAuthPassword()
    {
        return $this->password;
    }
}
