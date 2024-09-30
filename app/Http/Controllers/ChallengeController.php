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



class ChallengeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $challenges = Challenge::where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->paginate(5);
    
            $currentDate = Carbon::now();

            // Update challenge statuses based on end date
            foreach ($challenges as $challenge) {
                $endDate = Carbon::parse($challenge->end_date);
                if ($currentDate->gte($endDate) && $challenge->status !== 'closed') {
                    $challenge->status = 'closed';
                    $challenge->save();
                } elseif ($currentDate->lt($endDate) && $challenge->status === 'closed') {
                    $challenge->status = 'open';
                    $challenge->save();
                }
            }
        
        

            if ($request->ajax()) {
                return view('Back.Challenges.table_rows', compact('challenges'));
            }
            
    
        return view('Back.Challenges.index', compact('challenges', 'search'));
    }
    
    public function create()
    {
        return view('Back.Challenges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'reward_points' => 'required|integer|min:1|max:1000',
            'image' => 'image|nullable|max:2048', // validate image
        ]);
    
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('challenges', 'public'); // Store image in 'public/challenges'
        }
    
        Challenge::create($data);
        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully');
    }
    

    public function show($id)
    {
        $challenge = Challenge::find($id);
        $currentDate = Carbon::now();
        $endDate = Carbon::parse($challenge->end_date);
    
        $sort = request('sort', 'latest');
    
        // Fetch all solutions, counting votes regardless of sort order
        $solutionsQuery = Solution::where('challenge_id', $challenge->id)
            ->with('user')
            ->withCount('votes'); // Count votes
    
        if ($sort === 'votes') {
            $solutionsQuery->orderBy('votes_count', 'desc');
        } else {
            // Default sorting by latest (created_at)
            $solutionsQuery->orderBy('created_at', 'desc');
        }
    
        // Execute the query
        $solutions = $solutionsQuery->get();
    
        $userId = auth()->id();
        foreach ($solutions as $solution) {
            $solution->voted = $solution->votes()->where('user_id', $userId)->exists();
        }
    
        
    
        $isClosed = $challenge->isClosed();
    
        // Get the maximum votes count
        $maxVotes = $solutions->max('votes_count');
    
        // Get all solutions that have the maximum votes
        $winningSolutions = $solutions->filter(function ($solution) use ($maxVotes) {
            return $solution->votes_count == $maxVotes;
        });
        return view('Back.Challenges.show', compact('challenge', 'solutions', 'isClosed', 'winningSolutions'));

    }

    public function edit($id)
    {
        $challenge = Challenge::findOrFail($id);
        return view('Back.Challenges.edit', compact('challenge'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'reward_points' => 'required|integer|min:1|max:1000',
            'image' => 'image|nullable|max:2048', // Validate image
        ]);
    
        // Find the challenge by ID
        $challenge = Challenge::findOrFail($id);
    
        // Prepare data for updating
        $data = $request->all();
    
        // Check if there's a new image and store it
        if ($request->hasFile('image')) {
            // Store the new image
            $data['image'] = $request->file('image')->store('challenges', 'public');
    
            // Optionally, delete the old image if necessary
            // if ($challenge->image) {
            //     Storage::disk('public')->delete($challenge->image);
            // }
        } else {
            // If no new image is uploaded, keep the old image
            $data['image'] = $challenge->image;
        }
    
        // Update the challenge with the new data
        $challenge->update($data);
    
        return redirect()->route('challenges.index')->with('success', 'Challenge updated successfully');
    }
    

    public function destroy($id)
    {
        $challenge = Challenge::findOrFail($id);
        $challenge->delete();
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
        $statusFilter = $request->get('status', ''); // Get status filter (open, closed, upcoming, or empty for all)
        $currentDate = Carbon::now();
    
        // Base query for ongoing and past challenges
        $challengesQuery = Challenge::where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        });
    
        // Apply the status filter (open, closed, upcoming)
        if ($statusFilter === 'open') {
            $challengesQuery->where('status', 'open')->where('start_date', '<=', $currentDate);
        } elseif ($statusFilter === 'closed') {
            $challengesQuery->where('status', 'closed')->where('start_date', '<=', $currentDate);
        } elseif ($statusFilter === 'upcoming') {
            // If "upcoming" is selected, only fetch upcoming challenges
            $challengesQuery->where('start_date', '>', $currentDate);
        } else {
            // If no status filter, get both ongoing/past and upcoming challenges
            $challengesQuery = Challenge::where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            })->where(function ($query) use ($currentDate) {
                $query->where('start_date', '<=', $currentDate) // Ongoing and past challenges
                      ->orWhere('start_date', '>', $currentDate); // Upcoming challenges
            });
        }
    
        // Get paginated challenges
        $challenges = $challengesQuery->paginate(6);
    
        // Update challenge statuses based on end date (existing logic)
        foreach ($challenges as $challenge) {
            $endDate = Carbon::parse($challenge->end_date);
            if ($currentDate->gte($endDate) && $challenge->status !== 'closed') {
                $challenge->status = 'closed';
                $challenge->save();
    
                // Find the winning solution, counting votes dynamically
                $winningSolution = Solution::where('challenge_id', $challenge->id)
                    ->withCount('votes')
                    ->orderBy('votes_count', 'desc')
                    ->first();
    
                if ($winningSolution) {
                    $user = User::find($winningSolution->user_id);
                    if ($user) {
                        $user->score += $challenge->reward_points;
                        $user->save();
                        \Log::info('Sending email to: ' . $user->email);
                        Mail::to($user->email)->send(new ChallengeWinnerMail($user, $challenge));

                    }
                }
            } elseif ($currentDate->lt($endDate) && $challenge->status === 'closed') {
                $challenge->status = 'open';
                $challenge->save();
            }
        }
    
        if ($request->ajax()) {
            $html = view('Front.Challenges.challenges_list', compact('challenges'))->render();
            $pagination = $challenges->links('pagination::bootstrap-4')->render();
            return response()->json(['html' => $html, 'pagination' => $pagination]);
        }
        
    
        return view('Front.Challenges.index', compact('challenges', 'search', 'statusFilter'));
    }
    
    
public function showfront($id)
{
    $challenge = Challenge::find($id);
    $currentDate = Carbon::now();
    $endDate = Carbon::parse($challenge->end_date);
    
    // Determine the sorting preference
    $sort = request('sort', 'latest');
    
    // Fetch all solutions, counting votes regardless of sort order
    $solutionsQuery = Solution::where('challenge_id', $challenge->id)
        ->with('user')
        ->withCount('votes'); // Count votes

    // Apply sorting based on request
    if ($sort === 'votes') {
        $solutionsQuery->orderBy('votes_count', 'desc');
    } else {
        $solutionsQuery->orderBy('created_at', 'desc'); // Default sorting by latest
    }

    // Execute the query
    $solutions = $solutionsQuery->get();
    
    // Determine if the current user voted on each solution
    $userId = auth()->id();
    foreach ($solutions as $solution) {
        $solution->voted = $solution->votes()->where('user_id', $userId)->exists();
    }


    // Check if the challenge is closed
    $isClosed = $challenge->isClosed();
   

    // Get the maximum votes count to identify winning solutions
    $maxVotes = $solutions->max('votes_count');
    $winningSolutions = $solutions->filter(function ($solution) use ($maxVotes) {
        return $solution->votes_count == $maxVotes;
    });

    return view('Front.Challenges.show', compact('challenge', 'solutions', 'isClosed', 'winningSolutions'));
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