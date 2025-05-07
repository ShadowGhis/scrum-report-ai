<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LLMInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'prompt',
        'response',
        'model_used',
        'token_usage',
        'temperature',
        'error',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}

