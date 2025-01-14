<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniversityMajor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'university_major';

    protected $fillable = ['university_id', 'major_id', 'deleted_at'];
}
