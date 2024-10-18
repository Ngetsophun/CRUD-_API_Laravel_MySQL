<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Driver;
use App\Models\Customer;
use Illuminate\Http\Request;

class ChatController extends Controller
{
 
     // Send a new message
     public function sendMessage(Request $request)
     {
         $request->validate([
             'driver_id' => 'required|exists:drivers,id',
             'customer_id' => 'required|exists:customers,id',
             'message' => 'required|string',
             'sender_type' => 'required|in:driver,customer',
         ]);
 
         $chat = Chat::create([
             'driver_id' => $request->driver_id,
             'customer_id' => $request->customer_id,
             'message' => $request->message,
             'sender_type' => $request->sender_type,
             'seen_status' => 0, // Initially, message is not seen
         ]);
 
         return response()->json(['message' => 'Message sent successfully', 'chat' => $chat]);
     }
 
    // Mark a message as seen
public function markAsSeen(Request $request)
{
    $request->validate([
        'chat_id' => 'required|exists:chats,id',
        'user_type' => 'required|in:driver,customer',
    ]);

    $chat = Chat::find($request->chat_id);

    // Check if the user trying to mark the message as seen is the sender
    if (($chat->sender_type == 'driver' && $request->user_type == 'driver') ||
        ($chat->sender_type == 'customer' && $request->user_type == 'customer')) {
        // If the sender themselves is trying to mark the message as seen, don't change the status
        return response()->json(['message' => 'Sender cannot mark their own message as seen'], 403);
    }

    // Mark the message as seen only if the recipient is viewing it
    $chat->seen_status = 1;
    $chat->save();

    return response()->json(['message' => 'Message marked as seen']);
}

 
     // Retrieve all messages between driver and customer
     public function getMessages(Request $request)
     {
         $request->validate([
             'driver_id' => 'required|exists:drivers,id',
             'customer_id' => 'required|exists:customers,id',
         ]);
 
         $chats = Chat::where('driver_id', $request->driver_id)
             ->where('customer_id', $request->customer_id)
             ->orderBy('created_at', 'asc')
             ->get();
 
         return response()->json(['chats' => $chats]);
     }
}
