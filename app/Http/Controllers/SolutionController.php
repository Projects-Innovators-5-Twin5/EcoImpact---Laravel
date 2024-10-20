<?php

namespace App\Http\Controllers;

use App\Models\Solution;
use App\Models\Challenge;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\SolutionSubmitted;

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

        $admin = User::where('role', 'admin')->first(); // You can adjust this to notify all admins
        $challenge = Challenge::findOrFail($validatedData['challenge_id']);
        $user = auth()->user();

        $admin->notify(new SolutionSubmitted($user, $challenge));


        return redirect()->back()->with('success', 'Solution added successfully!');
    }



public function update(Request $request, $id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'required|string|min:3|max:100',
        'description' => 'required|string|min:10|max:500',
    ]);
    // Find the solution by its ID
    $solution = Solution::findOrFail($id);

    $solution->update([
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
    ]);

    // Return a success response
    return redirect()->route('challenges.showfront', $solution->challenge_id)->with('success', 'Solution updated successfully');

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


    public function submitSolution(Request $request, $challengeId)
{
    // Get the challenge and the user
    $challenge = Challenge::findOrFail($challengeId);
    $user = auth()->user();

    // Save the solution logic here...

    // Notify the admin (or all admins)
    $admin = User::where('role', 'admin')->first(); // Assuming 'role' is used to differentiate admin
    $admin->notify(new SolutionSubmitted($user, $challenge));

    return back()->with('success', 'Solution submitted successfully.');
}


}