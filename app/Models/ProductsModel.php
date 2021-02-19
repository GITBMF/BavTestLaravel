<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    use HasFactory;
    protected $table = "products_models";
    public $timestamps = true;
    protected $fillable = ["name", "price"];

    const PRODUCT_STORAGE = "/storage/products/";
}
