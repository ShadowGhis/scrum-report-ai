<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'user_id',
        'generated_by',
        'type',
        'generation_status',
        'generated_at',
        'content',
        'prompt_used',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    // 🔁 Relazioni

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // sviluppatore
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by'); // manager/admin
    }
}
