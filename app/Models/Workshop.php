<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workshop extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'university_id',
        'title',
        'address',
        'requirement',
        'description',
        'start_date',
        'end_date',
        'slug',
        'status',
        'is_active'
    ];

    public function enterprises()
    {
        return $this->belongsToMany(Enterprise::class, 'workshop_enterprise')->withPivot('status', 'deleted_at')->withTimestamps();
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'workshop_major', 'workshop_id', 'major_id')->withPivot(['deleted_at']);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
