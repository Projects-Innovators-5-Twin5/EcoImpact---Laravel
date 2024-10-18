<?php

namespace App\Models;
use App\Models\SensibilisationCampaign;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignParticipation extends Model
{
    use HasFactory;


    protected $fillable = [
        'campaign_id', 
        'name',
        'email',
        'phone',
        'reasons',
        'status'
    ];


    public function campaign()
    {
        return $this->belongsTo(SensibilisationCampaign::class);
    }
}
