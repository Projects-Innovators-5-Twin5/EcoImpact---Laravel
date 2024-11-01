<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SensibilisationCampaign;
use App\Models\CampaignParticipation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;


use PDF;

class SensibilisatioCompagneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    $endpointUrl = 'http://localhost:1064/api/campaign/all';

    $response = Http::get($endpointUrl);

    if ($response->successful()) {
        $campaignsData = $response->json();

        $campaigns = [];
        foreach ($campaignsData as $data) {
            $campaign = new SensibilisationCampaign();
            $campaign->idCampaign = $data['id'] ?? null;
            $campaign->title = $data['title'] ?? null;
            $campaign->target_audience = $data['targetAudience'] ?? null;
            $campaign->start_date = Carbon::parse($data['startDate'] ?? null);
            $campaign->end_date = Carbon::parse($data['endDate'] ?? null);

            if ($campaign->end_date && $campaign->end_date->lt(Carbon::today())) {
                $campaign->status = 'completed';
            } elseif ($campaign->start_date && $campaign->start_date->lte(Carbon::today())) {
                $campaign->status = 'active';
            } else {
                $campaign->status = 'upcoming';
            }

            $campaigns[] = $campaign;
        }

        // Count campaigns by status
        $activeCampaignsCount = count(array_filter($campaigns, fn($c) => $c->status == 'active'));
        $upcomingCampaignsCount = count(array_filter($campaigns, fn($c) => $c->status == 'upcoming'));
        $completedCampaignsCount = count(array_filter($campaigns, fn($c) => $c->status == 'completed'));

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 5;

        $currentCampaigns = array_slice($campaigns, ($currentPage - 1) * $perPage, $perPage);

        // Create the paginator
        $campaigns = new LengthAwarePaginator($currentCampaigns, count($campaigns), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        return View('Back.CompagneSensibilisation.compagneList', compact('campaigns', 'activeCampaignsCount', 'upcomingCampaignsCount', 'completedCampaignsCount'));
    } else {
        // Handle the error response
        return View('Back.CompagneSensibilisation.compagneList')->withErrors(['msg' => 'Failed to fetch campaigns.']);
    }
    }



    public function indexFront()
    {
        $endpointUrl = 'http://localhost:1064/api/campaign/all';

        $response = Http::get($endpointUrl);

        if ($response->successful()) {
            $campaignsData = $response->json();

            $activeCampaigns = [];
            $upcomingCampaigns = [];
            $completedCampaigns = [];

            foreach ($campaignsData as $data) {
                $campaign = new SensibilisationCampaign();
                $campaign->idCampaign = $data['id'] ?? null;
                $campaign->title = $data['title'] ?? null;
                $campaign->description = $data['description'] ?? null;
                $campaign->target_audience = $data['targetAudience'] ?? null;
                $campaign->start_date = Carbon::parse($data['startDate'] ?? null);
                $campaign->end_date = Carbon::parse($data['endDate'] ?? null);
                $campaign->image = $data['image'] ?? null;

                // Determine campaign status and categorize
                if ($campaign->end_date && $campaign->end_date->lt(Carbon::today())) {
                    $campaign->status = 'completed';
                    $completedCampaigns[] = $campaign;
                } elseif ($campaign->start_date && $campaign->start_date->lte(Carbon::today())) {
                    $campaign->status = 'active';
                    $activeCampaigns[] = $campaign;
                } else {
                    $campaign->status = 'upcoming';
                    $upcomingCampaigns[] = $campaign;
                }
            }

            // Pass the categorized lists to the view
            return View('Front.CompagneSensibilisation.compagneList', compact('activeCampaigns', 'upcomingCampaigns', 'completedCampaigns'));
        } else {
            // Handle the error response
            return View('Front.CompagneSensibilisation.compagneList')->withErrors(['msg' => 'Failed to fetch campaigns.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    public function calendar()
    {

        return view('Back.CompagneSensibilisation.compagneCalendar');
    }


    public function calendarData()
    {
        $campaigns = SensibilisationCampaign::all();

        return response()->json($campaigns);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            // Validate incoming data
            $validatedData = $request->validate([
                'title' => 'required|string|min:4|max:255',
                'description' => 'required|string|min:2|max:200',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
                'target_audience' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif'
            ]);

            // Handle the status based on the start date
            $status = Carbon::parse($request->input('start_date'))->gt(Carbon::today()) ? 'upcoming' : 'active';

            // Store the image if provided
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('images', 'public'); // Save in the 'public/images' directory
            }

            // Prepare the payload for the API
            $payload = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'startDate' => $request->input('start_date'),
                'endDate' => $request->input('end_date'),
                'targetAudience' => implode(',', $request->input('target_audience')), // Convert array to comma-separated string
                'status' => $status,
                'image' => $imagePath,
            ];

            // Define the endpoint URL
            $endpointUrl = 'http://localhost:1064/api/campaign/create';

            // Send POST request to API
            $response = Http::post($endpointUrl, $payload);

            if (!$response->successful()) {
                \Log::error('API Error:', ['response' => $response->json()]);
                return back()->withErrors(['msg' => 'Failed to add campaign. Check logs for details.'])->withInput();
            }

            if ($response->successful()) {
                return redirect()->route('campaigns.index')->with('success', 'Campaign added successfully.');
            } else {
                return back()->withErrors(['msg' => 'Failed to add campaign.'])->withInput();
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $endpointUrl = "http://localhost:1064/api/campaign/{$id}";

        $response = Http::get($endpointUrl);

        if ($response->successful()) {
            $campaignData = $response->json();

            $campaign = new SensibilisationCampaign();
            $campaign->idCampaign = $campaignData['idCampaign'] ?? null;
            $campaign->title = $campaignData['titleCampaign'] ?? null;
            $campaign->description = $campaignData['descriptionCampaign'] ?? null;
            $campaign->start_date = Carbon::parse($campaignData['startDateCampaign'] ?? null);
            $campaign->end_date = Carbon::parse($campaignData['endDateCampaign'] ?? null);
            $campaign->target_audience = $campaignData['targetCampaign'] ?? null;
            $campaign->status = $campaignData['statusCampaign'] ?? null;
            $campaign->image = $campaignData['imageCampaign'] ?? null;

            $startDate = $campaign->start_date;
            $endDate = $campaign->end_date;

            return view('Front.CompagneSensibilisation.compagneDetails', compact('campaign', 'startDate', 'endDate'));
        } else {
            // Handle API error response
            return redirect()->route('campaigns.index')->withErrors(['msg' => 'Failed to fetch campaign details.']);
        }
    }


    public function showBack($id)
    {
        $endpointUrl = "http://localhost:1064/api/campaign/{$id}";

        $response = Http::get($endpointUrl);

        if ($response->successful()) {
            $campaignData = $response->json();

            $campaign = new SensibilisationCampaign();
            $campaign->idCampaign = $campaignData['id'] ?? null;
            $campaign->title = $campaignData['titleCampaign'] ?? null;
            $campaign->description = $campaignData['descriptionCampaign'] ?? null;
            $campaign->start_date = Carbon::parse($campaignData['startDateCampaign'] ?? null);
            $campaign->end_date = Carbon::parse($campaignData['endDateCampaign'] ?? null);
            $campaign->target_audience = $campaignData['targetCampaign'] ?? null;
            $campaign->status = $campaignData['statusCampaign'] ?? null;
            $campaign->image = $campaignData['imageCampaign'] ?? null;

            // Fetch participants for the campaign
            $participantsEndpointUrl = "http://localhost:1064/api/campaign/{$id}/participants";

            $participantsResponse = Http::get($participantsEndpointUrl);

            $participants = [];
            if ($participantsResponse->successful()) {
                $participants = $participantsResponse->json();
            } else {
                \Log::error('Failed to fetch participants:', ['campaign_id' => $id, 'response' => $participantsResponse->json()]);
            }

            $startDate = $campaign->start_date;
            $endDate = $campaign->end_date;

            return view('Back.CompagneSensibilisation.compagneDetails', compact('campaign', 'startDate', 'endDate','participants'));
        } else {
            // Handle API error response
            return redirect()->route('campaigns.index')->withErrors(['msg' => 'Failed to fetch campaign details.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Define the endpoint URL for retrieving the campaign details
    $endpointUrl = "http://localhost:1064/api/campaign/{$id}";

    // Send GET request to the API
    $response = Http::get($endpointUrl);

    if ($response->successful()) {
        $campaignData = $response->json();

        $campaign = new SensibilisationCampaign();
        $campaign->idCampaign = $campaignData['idCampaign'] ?? null;
        $campaign->title = $campaignData['titleCampaign'] ?? null;
        $campaign->description = $campaignData['descriptionCampaign'] ?? null;
        $campaign->start_date = Carbon::parse($campaignData['startDateCampaign'] ?? null);
        $campaign->end_date = Carbon::parse($campaignData['endDateCampaign'] ?? null);
        $campaign->target_audience = $campaignData['targetCampaign'] ?? null;
        $campaign->status = $campaignData['statusCampaign'] ?? null;
        $campaign->image = $campaignData['imageCampaign'] ?? null;

        return view('Back.CompagneSensibilisation.editCompagne', compact('campaign'));
    } else {
        // Handle API error response
        return redirect()->route('campaigns.index')->withErrors(['msg' => 'Failed to fetch campaign details.']);
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            // Validate incoming data
            $validatedData = $request->validate([
                'title' => 'required|string|min:4|max:255',
                'description' => 'required|string|min:2|max:200',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
                'target_audience' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'reasons_join_campaign' => 'required'
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('images', 'public');
            }

            $payload = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'startDate' => $request->input('start_date'),
                'endDate' => $request->input('end_date'),
                'targetAudience' => $request->input('target_audience'),
                'status' =>  $request->input('status'),
                'reasonsJoinCampaign'=>$request->input('reasons_join_campaign') ,
                'image' =>  $imagePath,
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('images', 'public');
                $payload['image'] = $imagePath;
            }

        $endpointUrl = "http://localhost:1064/api/campaign/update/{$id}";

        $response = Http::put($endpointUrl, $payload);

        if ($response->successful()) {
            return redirect()->route('campaigns.index')->with('success', 'Campaign edited successfully.');
        } else {
            \Log::error('API Update Error', [
                'response_status' => $response->status(),
                'response_body' => $response->body(),
                'payload' => $payload,
            ]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $endpointUrl = "http://localhost:1064/api/campaign/delete/{$id}";

        $response = Http::delete($endpointUrl);

        if ($response->successful()) {
            return redirect()->route('campaigns.index')->with('success', 'Campaign deleted successfully.');
        } else {
            // Handle errors
            $errorMessage = $response->json()['message'] ?? 'Failed to delete campaign.';
            return redirect()->route('campaigns.index')->withErrors(['msg' => $errorMessage]);
        }
    }


    public function archive($id)
    {
        $campaign = SensibilisationCampaign::findOrFail($id);

        $campaign->status = 'archived';

        $campaign->save();

        return redirect()->route('campaigns.index')->with('success', 'Campaign archived successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = SensibilisationCampaign::where('title', 'LIKE', "%{$query}%")->get();

        return response()->json($results);
    }

    public function searchByStatus(Request $request)
    {
        $query = $request->input('query', '');

        if ($query === 'all' || empty($query)) {
            $results = SensibilisationCampaign::all();
        } else {
            $results = SensibilisationCampaign::where('status', 'LIKE', "%{$query}%")->get();
        }

        return response()->json($results);
    }

    public function exportPdf()
    {
        $data = SensibilisationCampaign::all();

        $pdf = PDF::loadView('Back.CompagneSensibilisation.compagnePDF', compact('data'));

        return $pdf->download('table_campaigns.pdf');
    }

    public function updateDateCampaignCalendar(Request $request)
    {

        $campaignId = $request->input('id');
        $campaignStartDate = $request->input('start');
        $campaignEndDate = $request->input('end');

        $campaign = SensibilisationCampaign::find($campaignId);

        $campaign->start_date = $campaignStartDate;
        $campaign->end_date = $campaignEndDate;

        $campaign->save();

        return response()->json([
            'success' => true,
            'message' => 'Les dates de la campagne ont été mises à jour avec succès.',
            'campaign' => $campaign
        ]);

    }


}
