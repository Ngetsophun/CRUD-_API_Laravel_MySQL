<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function placeOrder(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id', // Check if the product exists
            'qty' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        //return response()->json(["message"=>"Order product success!",200]);

        // Retrieve the product
        $product = Product::find($request->id);
      

        // Calculate the total price based on product price and quantity
        $totalPrice = $product->price * $request->qty;

        // Create the order
        $order = Order::create([
            'product_id' => $request->id,
            'quantity' => $request->qty,
            'total_price' => $totalPrice,
        ]);

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order,
        ], 201);
    }
}
