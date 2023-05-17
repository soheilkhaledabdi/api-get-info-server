<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends  Model
{

    protected $fillable = [
        'key',
        'description',
        'expire_at'
    ];

}
