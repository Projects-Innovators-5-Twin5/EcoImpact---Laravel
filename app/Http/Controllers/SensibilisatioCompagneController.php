<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SensibilisationCampaign;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
        //
    }

    public function archive($id)
    {
        $campaign = SensibilisationCampaign::findOrFail($id);

        $campaign->status = 'archived';

        $campaign->save();

        return redirect()->route('campaigns.index')->with('success', 'Campaign archived successfully.');
    }
}
