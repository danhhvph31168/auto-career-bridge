<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enterprise extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $with = [
        'universities'
    ];

    protected $table = 'enterprises';

    protected $fillable = [
        'name',
        'logo',
        'email',
        'phone',
        'address',
        'tax_code',
        'size',
        'introduce',
        'industry',
        'description',
        'url',
        'is_verify',
        'slug'
    ];

    public function universities()
    {
        return $this->belongsToMany(University::class, 'collaborations', 'enterprise_id', 'university_id')
            ->withPivot('id', 'status', 'send_name', 'created_at', 'updated_at')->withTimestamps();
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function workshops()
    {
        return $this->belongsToMany(Workshop::class, 'workshop_enterprise', 'enterprise_id', 'workshop_id')
            ->withPivot('id', 'status', 'send_name', 'created_at', 'updated_at')->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
