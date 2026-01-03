<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable = [
        'name',
        'email',
        'reception_date_time',
        'last_ip'
    ];
}
