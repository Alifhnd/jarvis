<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductTrans extends Model
{
    protected $table = 'products_trans';
    protected $fillable = [
        "title",
        "locale",
        "description",
        "product_id",
        "language_id",
    ];
}
