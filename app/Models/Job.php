<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jobs';

    protected $fillable = [
        'major_id',
        'enterprise_id',
        'title',
        'address',
        'requirement',
        'working_time',
        'experience_level',
        'benefit',
        'start_date',
        'end_date',
        'salary',
        'applicants',
        'slug',
        'description',
        'type',
        'status',
        'is_active',
        'changeByUser',
    ];

    public function enterprises()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function universities()
    {
        return $this->belongsToMany(University::class, 'job_university')
            ->withPivot('status', 'created_at', 'updated_at', 'deleted_at')
            ->orderBy('job_university.status');
    }
}
