<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'tb_supplier';
    protected $guarded = [];

    protected $hidden = [
        // 'id',
    ];
}
