<?php

namespace App\Basket;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'id','name'
    ];
}
