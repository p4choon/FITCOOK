<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description'
        // ,'exercises'
    ];

    protected $casts = [
        'exercises' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class)
            ->withPivot(['sets', 'repetitions', 'rest_time', 'tips']);
    }

    public function routineExercises()
    {
        return $this->hasMany(RoutineExercise::class);
    }
}
