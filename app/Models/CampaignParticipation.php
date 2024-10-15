<?php

namespace App\Models;
use App\Models\SensibilisationCampaign;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignParticipation extends Model
{
    use HasFactory;


    protected $fillable = [
        'campaign_id', 
        'user_id',
        'reasons',
        'status'
    ];


    public function campaign()
    {
        return $this->belongsTo(SensibilisationCampaign::class);
    }

    public function user()
    {
         return $this->belongsTo(User::class);
    }
}
