<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyConsumption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'energy_type',
        'energy_value',
        'consumption_date',
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
        'consumption_date' => 'datetime',
    ];

    /**
     * Relation avec le modèle User (un utilisateur peut avoir plusieurs consommations d'énergie).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec CarbonFootprint (une consommation d'énergie peut avoir un enregistrement d'empreinte carbone).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function carbonFootprint()
    {
        return $this->hasOne(CarbonFootprint::class);
    }
}
