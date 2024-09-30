<?php

namespace App\Http\Controllers;

use App\Models\Solution;
use App\Models\Challenge;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function create($challengeId)
    {
        $challenge = Challenge::findOrFail($challengeId);
        return view('solutions.create', compact('challenge'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:10|max:500',
                'challenge_id' => 'required|exists:challenges,id',
        ]);
    
        // Assuming you have a Solution model set up
        Solution::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'challenge_id' => $validatedData['challenge_id'],
            'user_id' => auth()->id(), // Store the logged-in user's ID
        ]);
    
        return redirect()->back()->with('success', 'Solution added successfully!');
    }
 

    public function edit($id)
    {
        $solution = Solution::findOrFail($id);
        return response()->json($solution); // Return as JSON for AJAX
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:10|max:500',
        ]);
    
        $solution = Solution::findOrFail($id);
    
        // Update the solution with the validated data
        $solution->update($request->only(['title', 'description']));
    
        // Return JSON response for AJAX success handling
        return response()->json(['success' => 'Solution updated successfully!']);
    }
    
    
    
    public function destroy($id)
    {
        $solution = Solution::findOrFail($id);
        $solution->delete();
        return redirect()->back()->with('success', 'Solution deleted successfully!');
    }

    public function voteSolution(Request $request, $solutionId)
    {
        $solution = Solution::findOrFail($solutionId);
        
        // Here we can assume you have a pivot table called 'solution_votes'
        // You may need to create a migration for it
        $userId = auth()->id();
    
        // Check if the user has already voted
        $hasVoted = $solution->votes()->where('user_id', $userId)->exists();
    
        if ($hasVoted) {
            // User has already voted, you can choose to unvote
            $solution->votes()->where('user_id', $userId)->delete();
            $voteCount = $solution->votes()->count(); // Update the count
            return response()->json(['message' => 'Vote removed!', 'voteCount' => $voteCount]);
        } else {
            // User has not voted, add their vote
            $solution->votes()->create(['user_id' => $userId]);
            $voteCount = $solution->votes()->count(); // Update the count
            return response()->json(['message' => 'Voted successfully!', 'voteCount' => $voteCount]);
        }
    }
    
    public function getVoters($solutionId)
    {
        $solution = Solution::findOrFail($solutionId);
        $voters = $solution->voters; // Assuming you have a relationship defined in your Solution model
    
        return response()->json(['voters' => $voters]);
    }
    
}
