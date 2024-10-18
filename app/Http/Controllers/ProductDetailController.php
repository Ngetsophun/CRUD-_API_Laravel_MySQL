<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Validator;

class ProductDetailController extends Controller
{
    //
    public function get_product_detail(Request $request){
        

        $productDetail = ProductDetail::all();

        return response()->json($productDetail,200);
        
    }


    public function deleteProductDetails($id){
        $productdetail = ProductDetail::find($id);
        if(!$productdetail){
            return response()->json(['error'=>"Product detail not found!",404]);
        }
        $productdetail->delete();
        return response()->json(['message' => 'Product deleted successfully'],200);
    }
}
