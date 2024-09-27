<?php

namespace App\Http\Controllers;
use App\Models\Challenge;
use App\Models\Solution;
use App\Models\User ;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function dashboard(){
        $totalChallenges = Challenge::count();
        $totalSolutions = Solution::count();
       $challengesOpen= Challenge::where('status', 'open')->count();
        $challengesClosed = Challenge::where('status', 'closed')->count();
    
    
        return view('Back.dashboard', compact('totalChallenges', 'totalSolutions', 'challengesOpen','challengesClosed'));
    }


}
