<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class University extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'logo',
        'email',
        'phone',
        'address',
        'description',
        'introduce',
        'url'
    ];
    protected $table = 'universities';
    public function users()
    {
        return $this->hasMany(User::class, 'university_id', 'id');
    }

    protected $with = [
        'majors',
        'users',
    ];

    public function enterprises()
    {
        return $this->belongsToMany(Enterprise::class, 'collaborations', 'university_id', 'enterprise_id')
            ->withPivot('id', 'status', 'send_name', 'deleted_at', 'created_at', 'updated_at')->withTimestamps();
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'university_major')->withPivot('deleted_at', 'created_at');
    }

    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_university')->withPivot('status', 'created_at', 'updated_at', 'deleted_at');
    }
}
