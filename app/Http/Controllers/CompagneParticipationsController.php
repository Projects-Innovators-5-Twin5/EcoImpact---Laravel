<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensibilisationCampaign;
use App\Models\User;
use App\Models\CampaignParticipation;
use App\Mail\MailParticipationAccepted;
use App\Mail\MailParticipation;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;


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


    public function listParticipation()
    { 
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $participations = CampaignParticipation::with('campaign')->where('user_id' , Auth::id())->whereIn('status', ['accepted', 'pending'])->get();

        return view('Front.CompagneSensibilisation.campaignParticipationList', compact('participations','user'));

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
            'reasons' => 'required|string|min:100|max:1000',
        ]);

        $id=$request->input('campaign_id');

        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $campaign_participation = CampaignParticipation::create([
            'campaign_id' => $id,
            'user_id'=> $userId,
            'reasons' => $request->input('reasons')
        ]);

        $campaign = SensibilisationCampaign::findOrFail($id);
        $startDate = Carbon::parse($campaign->start_date);
        $endDate = Carbon::parse($campaign->end_date);

        $data = [
            'name' => $user->name,
            'participation_date'=>$campaign_participation->created_at,
            'campaign_name'=>$campaign->title,
            'campaign_startDate'=>$campaign->start_date,
        ];

        Mail::to($user->email)->send(new MailParticipation($data));

        return redirect()->route('campaigns.show' , $id)->with('success', 'participation created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign_participation = CampaignParticipation::with('campaign')->findOrFail($id);
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $campaign = SensibilisationCampaign::findOrFail($campaign_participation->campaign_id);
        $startDate = Carbon::parse($campaign->start_date);
        $endDate = Carbon::parse($campaign->end_date);

        return view('Front.CompagneSensibilisation.detailsParticipationCompagne', compact('campaign_participation','user','startDate','endDate'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaign_participation = CampaignParticipation::with('user')->findOrFail($id);
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        return view('Front.CompagneSensibilisation.editParticipationCompagne', compact('campaign_participation','user'));
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
            'reasons' => 'required|string|min:100|max:1000',
        ]);

        $participation_campaign = CampaignParticipation::findOrFail($id);

        $participation_campaign->update([
            'reasons' => $request->input('reasons'),
        ]);

        return redirect()->route('participation.front.list')->with('success', 'participation campaign edited successfully.');
    }


    public function acceptParticipation($id)
    {
        $campaign_participation = CampaignParticipation::findOrFail($id);
        $campaign_participation->status = 'accepted';

        $campaign_participation->save();

        $campaign = SensibilisationCampaign::findOrFail($campaign_participation->campaign_id);
        $user = User::findorFail($campaign_participation->user_id);

        $data = [
            'name' => $user->name,
            'participation_date'=>$campaign_participation->created_at,
            'campaign_name'=>$campaign->title,
            'campaign_startDate'=>$campaign->start_date,
        ];

        Mail::to($user->email)->send(new MailParticipationAccepted($data));
         
        return redirect()->route('campaigns.showBack',$campaign->id)->with('success', 'participation accepted successfully.');
    }


    public function rejectParticipation($id)
    {
        $campaign_participation = CampaignParticipation::findOrFail($id);
        $campaign = SensibilisationCampaign::findOrFail($campaign_participation->campaign_id);
        $campaign_participation->status = 'rejected';

        $campaign_participation->save();
         
        return redirect()->route('campaigns.showBack',$campaign->id)->with('success', 'participation rejected successfully.');
    }


    public function cancelParticipation($id)
    {
        $campaign_participation = CampaignParticipation::findOrFail($id);

        $campaign_participation->delete();
         
        return redirect()->route('participation.front.list');
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
        $campaign = SensibilisationCampaign::findOrFail($participant->campaign_id);

        $participant->delete();

        return redirect()->route('campaigns.showBack',$campaign->id)->with('success', 'Participant deleted successfully.');
    }

    public function search(Request $request , $id)
    {
        $query = $request->input('query');

        $results = CampaignParticipation::with('user') 
        ->where('campaign_id', $id) 
        ->whereHas('user', function ($q) use ($query) { 
            $q->where('name', 'LIKE', "%{$query}%");
        })
        ->get();
        return response()->json($results);
    }

    public function searchByStatus(Request $request,$id)
    {
        $query = $request->input('query', ''); 

        if ($query === 'all' || empty($query)) {
            $results = CampaignParticipation::with('user')->where('campaign_id', $id)->get();
        } else {
            $results = CampaignParticipation::with('user')->where('campaign_id', $id)
                                            ->where('status', 'LIKE', "%{$query}%")
                                            ->get();
        }
        
        return response()->json($results);
    }

    public function exportPdf_Participants($id)
    {
        $participants = CampaignParticipation::where('campaign_id', $id)->get();

        $campaign = SensibilisationCampaign::findOrFail($id);

        $pdf = PDF::loadView('Back.CompagneSensibilisation.participantsPDF', compact('participants' , 'campaign'));

        return $pdf->download('table_participants.pdf');
    }
}
