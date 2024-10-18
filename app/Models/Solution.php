<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'challenge_id',
        'user_id', // Assuming you want to mass assign user_id as well
    ];
    public function challenge()
{
    return $this->belongsTo(Challenge::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
public function votes()
{
    return $this->hasMany(Vote::class);
}
public function voters()
{
    return $this->belongsToMany(User::class, 'votes'); // Assuming you have a pivot table 'votes'
}


}
