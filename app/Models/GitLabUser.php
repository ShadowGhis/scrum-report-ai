<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GitLabUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'gitlab_id',
        'username',
        'name',
        'avatar_url',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}