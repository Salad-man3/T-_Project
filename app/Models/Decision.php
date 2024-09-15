<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    use HasFactory;

    protected $fillable = [
        'decision_id',
        'decision_date',
        'title',
        'description',
    ];

    protected $casts = [
        'decision_date' => 'date',
    ];
}
