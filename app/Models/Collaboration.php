<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collaboration extends Model
{
    use HasFactory;

    protected $fillable = [
        'enterprise_id',
        'university_id',
        'status',
        'send_name',
    ];
}
