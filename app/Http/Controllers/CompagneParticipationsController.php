<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensibilisationCampaign;
use App\Models\CampaignParticipation;
use Carbon\Carbon;


class CompagneParticipationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($campaign_id)
    {

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($campaign_id)
    {
        $campaign = SensibilisationCampaign::findOrFail($campaign_id);

        return view('Front.CompagneSensibilisation.addParticipationCompagne', compact('campaign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits:8',
            'reasons' => 'required|string|min:100|max:1000',
        ]);

        CampaignParticipation::create([
            'campaign_id' => $request->input('campaign_id'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'reasons' => $request->input('reasons')
        ]);

        $id=$request->input('campaign_id');

        $campaign = SensibilisationCampaign::findOrFail($id);
        $startDate = Carbon::parse($campaign->start_date);
        $endDate = Carbon::parse($campaign->end_date);

        return redirect()->route('campaignsFront.index')->with('success', 'participation created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
