<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function get_product(Request $request){
        $products = Product::paginate(3);
        return response()->json($products);
    }

    public function insert_product(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'qty' => 'required|integer',
            'price' => 'required|string',
 
        ]);
     
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $product = Product::create([
                'name' => $request->input('name'),
                'qty' => $request->input('qty'),
                'price' => $request->input('price'),
                'description' => $request->input('description')
            ]);
            return response()->json([
                'message' => 'Product successfully created',
                'product' => $product
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Product creation failed: ' . $e->getMessage()], 500);
        }
    }

    public function update_product(Request $request, $id){

        $validator = Validator::make($request->all(),
        [
            'name' => 'sometimes|required|string',
            'qty' => 'sometimes|required|integer',
            'price' => 'sometimes|required|string',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $product = Product::find($id);

        if(!$product){
            return response()->json(['error'=>"Product not Found!",404]);
        }

    
        $product->update($request->only(['name', 'qty', 'price', 'description']));

        // Return a success response
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200);

    }

    public function delete_product($id){

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();
    
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    public function getProductWithDetails($id){
        $product = Product::with('details')->find($id);

    
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }


        return response()->json($product, 200);
    }

}
