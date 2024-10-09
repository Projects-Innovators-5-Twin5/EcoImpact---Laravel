<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonFootprint extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'energy_consumption_id',
        'carbon_emission',
        'calculation_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Ajoutez ici les champs que vous souhaitez masquer lors de la sérialisation, s'il y en a
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'calculation_date' => 'datetime',
    ];

    /**
     * Relation avec le modèle User (un utilisateur peut avoir plusieurs empreintes carbone).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec EnergyConsumption (chaque empreinte carbone est liée à une consommation d'énergie).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function energyConsumption()
    {
        return $this->belongsTo(EnergyConsumption::class, 'energy_consumption_id');
    }
}
