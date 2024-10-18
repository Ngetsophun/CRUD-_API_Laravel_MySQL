<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class chatMessageController extends Controller
{
    //
    // Send a message
    public function sendMessage(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'recipient_id' => 'required|integer',
            'message' => 'required|string',
            'sender_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Insert message into chat_message table
        $messageId = DB::table('chat_message')->insertGetId([
            'recipient_id' => $request->recipient_id,
            'message' => $request->message,
            'sender' => $request->sender_id,
            'user_seen' => 0,
            'created_at' => now(),
        ]);

        return response()->json(['message_id' => $messageId], 201);
    }

    // Get chat history with a specific recipient
    public function getChatHistory($recipientId)
    {
        $chatHistory = DB::table('chat_message')
            ->where('recipient_id', $recipientId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($chatHistory);
    }

    // Mark message as seen
    public function markMessageSeen($messageId)
    {
        DB::table('chat_message')
            ->where('id', $messageId)
            ->update(['user_seen' => 1]);

        return response()->json(['message' => 'Message marked as seen.']);
    }
}
