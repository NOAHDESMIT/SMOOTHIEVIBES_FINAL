<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Smoothie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ingredients',
        'image',
        'user_id',
        'contains_oat_milk',
        'contains_regular_milk',
        'is_vegan',
        'health_category',
        'enabled', // Add 'enabled' to the fillable array
    ];

    protected $casts = [
        'contains_oat_milk' => 'boolean',
        'contains_regular_milk' => 'boolean',
        'is_vegan' => 'boolean',
        'user_id' => 'integer',
        'enabled' => 'boolean', // Cast 'enabled' as boolean
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
