<?php

namespace App\Http\Controllers;
use App\Models\Challenge;
use App\Models\Solution;
use App\Models\User ;
use App\Mail\ChallengeWinnerMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;


class ChallengeController extends Controller
{


    protected $client;
    protected $apiUrl = 'http://localhost:1064/api/challenges'; // Replace with your API URL

    public function __construct()
    {
        $this->client = new Client(); // Initialize Guzzle client
    }


    public function index(Request $request)
    {


            $response = $this->client->get($this->apiUrl . "/all");
            $challenges = json_decode($response->getBody(), true);

        return view('Back.Challenges.index', compact('challenges'));
    }

    public function create()
    {
        return view('Back.Challenges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:10|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rewardPoints' => 'required|integer|min:1|max:1000',
            'image' => 'image|required|max:2048',
        ]);

        $data = $request->all();

        $currentDate = Carbon::now();

        // Set the initial status based on the dates
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);

        if ($currentDate->gte($endDate)) {
            $data['status'] = 'closed';
        } elseif ($currentDate->lt($startDate)) {
            $data['status'] = 'upcoming';
        } else {
            $data['status'] = 'open';
        }


        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('challenges', 'public'); // Store image in 'public/challenges'
        }

        $response = $this->client->post($this->apiUrl . "/create", [
            'json' => $data,
        ]);
        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully');
    }


    public function show($id)
    {
        $challenge = Challenge::find($id);
        $currentDate = Carbon::now();
        $endDate = Carbon::parse($challenge->end_date);

        $sort = request('sort', 'latest');

        $solutionsQuery = Solution::where('challenge_id', $challenge->id)
            ->with('user')
            ->withCount('votes');

        if ($sort === 'votes') {
            $solutionsQuery->orderBy('votes_count', 'desc');
        } else {
            $solutionsQuery->orderBy('created_at', 'desc');
        }

        $solutions = $solutionsQuery->get();

        $userId = auth()->id();
        foreach ($solutions as $solution) {
            $solution->voted = $solution->votes()->where('user_id', $userId)->exists();
        }



        $isClosed = $challenge->isClosed();

        $maxVotes = $solutions->max('votes_count');

        $winningSolutions = $solutions->filter(function ($solution) use ($maxVotes) {
            return $solution->votes_count == $maxVotes;
        });






        return view('Back.Challenges.show', compact('challenge', 'solutions', 'isClosed', 'winningSolutions' ));

    }

    public function edit($id)
    {
        $response = $this->client->get("{$this->apiUrl}/{$id}");
        $challenge1 = json_decode($response->getBody(), true);

        // Create a new array with the desired attribute names
        $challenge = [
            'id' => $challenge1['idChallenge'],
            'title' => $challenge1['titleChallenge'],
            'description' => $challenge1['descriptionChallenge'],
            'start_date' => $challenge1['start_dateChallenge'],
            'end_date' => $challenge1['end_dateChallenge'],
            'rewardPoints' => $challenge1['rewardPoints'],
            'image' => $challenge1['imageChallenge'],
            'status' => $challenge1['statusChallenge'],


        ];
        return view('Back.Challenges.edit', compact('challenge'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:10|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rewardPoints' => 'required|integer|min:1|max:1000',
            'image' => 'image|nullable|max:2048',
            'status' => 'required|string',

        ]);

        // Fetch existing challenge data from the API
        $response = $this->client->get("{$this->apiUrl}/{$id}");
        $challenge = json_decode($response->getBody(), true);


        if ($request->hasFile('image')) {
            // If an image exists, delete the old one from storage
            if (isset($challenge['imageChallenge'])) { // Ensure this matches how the image is stored
                Storage::delete('public/' . $challenge['imageChallenge']);

            }

            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $challenge['imageChallenge'] = $imagePath; // Update the image path
        }


        $challenge['title'] = $request->input('title'); // Ensure the keys match
        $challenge['description'] = $request->input('description');
        $challenge['start_date'] = $request->input('start_date');
        $challenge['end_date'] = $request->input('end_date');
        $challenge['rewardPoints'] = $request->input('rewardPoints');
        $challenge['status'] = $request->input('status');



        $challenge2 = [
            'id' => $challenge['idChallenge'],
            'title' => $challenge['title'],
            'description' => $challenge['description'],
            'start_date' => $challenge['start_date'],
            'end_date' => $challenge['end_date'],
            'rewardPoints' => $challenge['rewardPoints'],
            'image' => $challenge['imageChallenge'],
            'status' => $challenge['status'],


        ];




        // Update the challenge via API
        $response = $this->client->put($this->apiUrl . "/update/{$id}", [
            'json' => $challenge2,
        ]);


        return redirect()->route('challenges.index')->with('success', 'Challenge updated successfully');
    }



    public function destroy($id)
    {
        $response = $this->client->delete($this->apiUrl . "/delete/{$id}");

        return redirect()->route('challenges.index')->with('success', 'Challenge deleted successfully');
    }

    public function exportPdf()
    {
        $challenges = Challenge::all();
        $pdf = PDF::loadView('Back.Challenges.pdf', compact('challenges'));

        return $pdf->download('challenges.pdf');
    }


    public function indexfront(Request $request)
    {
        $search = $request->get('search', '');
        $statusFilter = $request->get('status', ''); // Get status filter
        $currentDate = Carbon::now();

        // Fetch challenges from Spring Boot API using the HTTP client
        try {
            $response = $this->client->get($this->apiUrl . "/all");
            $challenges = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Handle the exception, maybe log it and set $challenges to an empty array
            \Log::error('Error fetching challenges: ' . $e->getMessage());
            $challenges = [];
        }

        // Optionally filter $challenges here based on $search and $statusFilter if needed

        if ($request->ajax()) {
            $html = view('Front.Challenges.challenges_list', compact('challenges'))->render();
            return response()->json(['html' => $html]);
        }

        return view('Front.Challenges.index', compact('challenges'));
    }



    public function showfront($id)
    {
        $response = $this->client->get($this->apiUrl . "/{$id}");
        $challenge = json_decode($response->getBody(), true);

        $currentDate = Carbon::now();
        $endDate = Carbon::parse($challenge['end_dateChallenge']); // Access end date using the correct key
        return view('Front.Challenges.show', compact('challenge'));
    }

public function leaderboard()
{
    $users = User::select('users.id', 'users.name', 'users.email', 'users.score') // Retrieve users' score from the database
        ->where('users.role', 'user')
        ->orderBy('users.score', 'DESC') // Order by the score in descending order
        ->get();

    return view('Front.Challenges.leaderboard', compact('users'));
}



}
