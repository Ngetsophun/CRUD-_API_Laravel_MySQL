<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_recipient extends Model
{
    use HasFactory;
    protected $table = 'chat_recipient'; // Specify the table name if it doesn't follow Laravel's naming conventions

    protected $fillable = [
        'from_user',
        'to_user',
        'status',
        'is_deleted',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'recipient_id');
    }
}
