<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_url',
        'photoable_id',
        'photoable_type',
    ];

    public function photoable()
    {
        return $this->morphTo();
    }
}
