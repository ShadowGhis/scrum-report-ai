<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'gitlab_project_id',
        'gitlab_url',
        'access_token',
        'visibility',   
        'created_by',
    ];
    
    public function create_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    public function gitlabUsers()
    {
        return $this->hasMany(GitLabUser::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function rawActivities()
    {
        return $this->hasMany(RawActivity::class);
    }

    public function labels()
    {
        return $this->hasMany(ProjectLabel::class);
    }
}
