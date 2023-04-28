<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'level',
        'muscle_groups',
        'video_url'
    ];

    public function routines()
    {
        return $this->belongsToMany(Routine::class)
            ->withPivot(['sets', 'repetitions', 'rest_time', 'tips']);
    }
}
