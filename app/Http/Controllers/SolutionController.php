<?php

namespace App\Http\Controllers;

use App\Models\Solution;
use App\Models\Challenge;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\SolutionSubmitted;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; // Use Laravel's built-in HTTP client

class SolutionController extends Controller
{


    protected $client;
    protected $apiUrl = 'http://localhost:1064/api/solutions'; // Replace with your API URL


    public function store(Request $request , $challenge_id)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:10|max:500',
        ]);


        $response = Http::post("{$this->apiUrl}/create/{$challenge_id}", [
            'title' => $request->input('title'), // Ensure these match the field names in the API
            'description' => $request->input('description'),
        ]);



        return redirect()->back()->with('success', 'Solution added successfully!');
    }


public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|min:3|max:100',
        'description' => 'required|string|min:10|max:500',
    ]);


    $response = Http::put("{$this->apiUrl}/update/{$id}", [
        'title' => $request->input('title'),
        'description' => $request->input('description'),

    ]);

    if ($response->successful()) {
        return back()->with('success', 'Solution mis à jour avec succès.');
    }

    return back()->with('error', 'Erreur lors de la mise à jour du Solution.');
}




    public function destroy($id)
    {

        $response = Http::delete("{$this->apiUrl}/delete/{$id}");

        if ($response->successful()) {
            return back()->with('success', 'Solution supprimé avec succès.');
        }

        return back()->with('error', 'Erreur lors de la suppression du solution.');

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
