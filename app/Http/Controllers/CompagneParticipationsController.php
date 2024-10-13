<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensibilisationCampaign;
use App\Models\CampaignParticipation;
use App\Mail\MailParticipationAccepted;
use App\Mail\MailParticipation;
use Illuminate\Support\Facades\Mail;
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
        $startDate = Carbon::parse($campaign->start_date);
        $endDate = Carbon::parse($campaign->end_date);

        return view('Front.CompagneSensibilisation.addParticipationCompagne', compact('campaign' , 'startDate','endDate'));
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

        $campaign_participation = CampaignParticipation::create([
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

        $data = [
            'name' => $campaign_participation->name,
            'participation_date'=>$campaign_participation->created_at,
            'campaign_name'=>$campaign->title,
            'campaign_startDate'=>$campaign->start_date,
        ];

        Mail::to($campaign_participation->email)->send(new MailParticipation($data));

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


    public function acceptParticipation($id)
    {
        $campaign_participation = CampaignParticipation::findOrFail($id);
        $campaign_participation->status = 'accepted';

        $campaign_participation->save();

        $campaign = SensibilisationCampaign::findOrFail($campaign_participation->campaign_id);

        $data = [
            'name' => $campaign_participation->name,
            'participation_date'=>$campaign_participation->created_at,
            'campaign_name'=>$campaign->title,
            'campaign_startDate'=>$campaign->start_date,
        ];

        Mail::to($campaign_participation->email)->send(new MailParticipationAccepted($data));
         
        return redirect()->route('campaigns.index')->with('success', 'participation accepted successfully.');
    }


    public function rejectParticipation($id)
    {
        $campaign_participation = CampaignParticipation::findOrFail($id);
        $campaign_participation->status = 'rejected';

        $campaign_participation->save();
         
        return redirect()->route('campaigns.index')->with('success', 'participation rejected successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $participant = CampaignParticipation::findOrFail($id);

        $participant->delete();

        return redirect()->route('campaigns.index')->with('success', 'Participant deleted successfully.');
    }

    public function search(Request $request , $id)
    {
        $query = $request->input('query');

        $results = CampaignParticipation::where('campaign_id', $id)
                                    ->where('name', 'LIKE', "%{$query}%")
                                    ->get();
        return response()->json($results);
    }

    public function searchByStatus(Request $request,$id)
    {
        $query = $request->input('query', ''); 

        if ($query === 'all' || empty($query)) {
            $results = CampaignParticipation::where('campaign_id', $id)->get();
        } else {
            $results = CampaignParticipation::where('campaign_id', $id)
                                            ->where('status', 'LIKE', "%{$query}%")
                                            ->get();
        }
        
        return response()->json($results);
    }
}
