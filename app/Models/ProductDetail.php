<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'produce',
        'additional_info',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // public static function getProduct(){
    //   $result = DB::select("SELECT * FROM product_detail");
    //     return ProductDetailController::getProduct($result);
    // }  
}
