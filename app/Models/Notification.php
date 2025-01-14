<?php

namespace App\Models;

use App\Events\Enterprise\NotificationReceive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'is_read',
        'sender_id',
        'receiver_id',
        'title',
        'message',
        'type',
        'censor_id',
    ];

    protected $with = ['sender', 'receiver'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
