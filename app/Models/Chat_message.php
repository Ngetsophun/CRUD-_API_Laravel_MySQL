<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_message extends Model
{
    use HasFactory;
    protected $table = 'chat_message'; // Specify the table name if it doesn't follow Laravel's naming conventions

    protected $fillable = [
        'recipient_id',
        'message',
        'sender',
        'user_seen',
    ];

    public function recipient()
    {
        return $this->belongsTo(ChatRecipient::class, 'recipient_id');
    }
}
