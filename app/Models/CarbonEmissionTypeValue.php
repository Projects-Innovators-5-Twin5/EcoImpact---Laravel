<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonEmissionTypeValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'energy_type',
        'carbon_emission_factor', // Changed to snake_case for consistency
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'energy_type' => 'string',
        'carbon_emission_factor' => 'float', // Changed to snake_case for consistency
    ];
}
