<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\Model;

class Adminlogin extends Authenticatable 
{
    use HasFactory,Notifiable;

    protected $table= "admins";


    protected $primarykey= "id";

    protected $guarded= [];

    // get Auth Password
    
    public function getAuthPassword()
    {
        return $this->password;
    }
}
