<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'duration',
        'min_age',
        'trailer_url',
        'genre',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}