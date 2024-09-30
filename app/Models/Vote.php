<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $fillable = ['solution_id', 'user_id'];

    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
