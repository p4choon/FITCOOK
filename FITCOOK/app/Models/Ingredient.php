<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'calories',
        'fat',
        'saturated_fat',
        'polyunsaturated_fat',
        'monounsaturated_fat',
        'trans_fat',
        'cholesterol',
        'sodium',
        'potassium',
        'carbohydrates',
        'fiber',
        'sugar',
        'protein',
        'vitamin_a',
        'vitamin_c',
        'calcium',
        'iron'
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)
            ->withPivot(['quantity', 'unit']);
    }
}
