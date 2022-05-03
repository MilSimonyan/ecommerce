<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute_Product extends Model
{
    use HasFactory;

    protected $table = 'attribute_product';


    protected $fillable = [
        'value'
    ];
}
