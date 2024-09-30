<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SensibilisationCampaign;
use App\Models\CampaignParticipation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
        $campaigns = SensibilisationCampaign::all();

        foreach ($campaigns as $campaign) {
            if (Carbon::parse($campaign->end_date)->lt(Carbon::today()) && ($campaign->status != 'archived')) {
                $campaign->status = 'completed';
                $campaign->save();
            }
            if (Carbon::parse($campaign->start_date)->lte(Carbon::today()) && ($campaign->status == 'upcoming')) {
                $campaign->status = 'active';
                $campaign->save();
            }
        }
        $activeCampaignsCount = SensibilisationCampaign::where('status', 'active')->count();
    
        $upcomingCampaignsCount = SensibilisationCampaign::where('status', 'upcoming')->count();

        $completedCampaignsCount = SensibilisationCampaign::where('status', 'completed')->count();

        $campaigns = SensibilisationCampaign::paginate(5);
    
        return View('Back.CompagneSensibilisation.compagneList', compact('campaigns' , 'activeCampaignsCount' , 'upcomingCampaignsCount','completedCampaignsCount'));
    }



    public function indexFront()
    {
        $activeCampaigns = SensibilisationCampaign::where('status', 'active')
        ->get();
    
        $upcomingCampaigns = SensibilisationCampaign::where('status', 'upcoming')
        ->get();

        $completedCampaigns = SensibilisationCampaign::where('status', 'completed')->whereBetween('end_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        $campaigns = SensibilisationCampaign::all();
        foreach ($campaigns as $campaign) {
            if (Carbon::parse($campaign->end_date)->lt(Carbon::today()) && ($campaign->status != 'archived')) {
                $campaign->status = 'completed';
                $campaign->save();
            }
            if (Carbon::parse($campaign->start_date)->lte(Carbon::today()) && ($campaign->status == 'upcoming')) {
                $campaign->status = 'active';
                $campaign->save();
            }
        }
        return view('Front.CompagneSensibilisation.compagneList', compact('activeCampaigns', 'upcomingCampaigns','completedCampaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|min:4|max:255',
            'description' => 'required|string|min:50|max:1000',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'target_audience' => 'required|array',
            'target_audience.*' => 'string|max:255', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        $startDate = $request->input('start_date');

        if (Carbon::parse($startDate)->gt(Carbon::today())) {
            $status = 'upcoming';
        } else {
            $status = 'active'; 
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
        }

        $campaign = SensibilisationCampaign::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'target_audience' => $request->input('target_audience'), 
            'status'=>$status
        ]);

        return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = SensibilisationCampaign::findOrFail($id);
        $startDate = Carbon::parse($campaign->start_date);
        $endDate = Carbon::parse($campaign->end_date);
        return view('Front.CompagneSensibilisation.compagneDetails', compact('campaign', 'startDate','endDate'));
    }


    public function showBack($id)
    {
        $campaign = SensibilisationCampaign::findOrFail($id);
        $startDate = Carbon::parse($campaign->start_date);
        $endDate = Carbon::parse($campaign->end_date);

        $campaigns_participations = CampaignParticipation::where('campaign_id', $campaign->id)->get();
        $campaigns_participations  = CampaignParticipation::paginate(5);

        return view('Back.CompagneSensibilisation.compagneDetails', compact('campaign', 'startDate','endDate','campaigns_participations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaign = SensibilisationCampaign::findOrFail($id);
   

        return view('Back.CompagneSensibilisation.editCompagne', compact('campaign'));
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
        $validatedData = $request->validate([
            'title' => 'required|string|min:4|max:255',
            'description' => 'required|string|min:150|max:1000',
            'reasons_join_campaign' => 'required|string|min:300|max:5000',
            'link_fb' => 'required|url|max:5000',
            'link_insta' => 'required|url|max:5000',
            'link_web' => 'required|url|max:5000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_audience' => 'required|array',
            'target_audience.*' => 'string|max:255', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $campaign = SensibilisationCampaign::findOrFail($id);

        $startDate = $request->input('start_date');
        $status = Carbon::parse($startDate)->gt(Carbon::today()) ? 'upcoming' : 'active';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
        } else {
            $imagePath = $campaign->image; 
        }

        $campaign->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'reasons_join_campaign' => $request->input('reasons_join_campaign'),
            'link_fb' => $request->input('link_fb'),
            'link_insta' => $request->input('link_insta'),
            'link_web' => $request->input('link_web'),
            'image' => $imagePath,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'target_audience' => $request->input('target_audience'),
            'status' => $status,
        ]);

        return redirect()->route('campaigns.index')->with('success', 'Campaign edited successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaign = SensibilisationCampaign::findOrFail($id);

        $campaign->delete();

        return redirect()->route('campaigns.index')->with('success', 'Campaign deleted successfully.');
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

}
