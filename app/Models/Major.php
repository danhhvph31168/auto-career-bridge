<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'majors';

    protected $fillable = [
        'name',
        'status',
        'description'
    ];

    public function universities()
    {
        return $this->belongsToMany(University::class, 'university_major', 'major_id', 'university_id')->withPivot('created_at', 'deleted_at')->withTimestamps();
    }
    public function workshops()
    {
        return $this->belongsToMany(Workshop::class, 'workshop_major')->withPivot('deleted_at');
    }
}
