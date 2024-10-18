<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CampaignParticipation;


class SensibilisationCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'reasons_join_campaign',
        'link_fb',
        'link_insta',
        'link_web',
        'image',
        'start_date',
        'end_date',
        'target_audience',
        'status'
    ];

    protected $casts = [
        'target_audience' => 'array',
    ];


    public function participations()
    {
        return $this->hasMany(CampaignParticipation::class);
    }
}
