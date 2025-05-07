<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectLabel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'label_name',
        'active',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
