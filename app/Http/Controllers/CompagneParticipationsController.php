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
use Illuminate\Support\Facades\Http;
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
        $endpointUrl = "http://localhost:1064/api/campaign/{$campaign_id}";

        $response = Http::get($endpointUrl);

        if ($response->successful()) {
            $campaignData = $response->json();

            $campaign = new SensibilisationCampaign();
            $campaign->idCampaign = $campaignData['idCampaign'] ?? null;
            $campaign->image = $campaignData['imageCampaign'] ?? null;

            $campaign->start_date = Carbon::parse($campaignData['startDateCampaign'] ?? null);
            $campaign->end_date = Carbon::parse($campaignData['endDateCampaign'] ?? null);
        }

            $startDate = $campaign->start_date;
            $endDate = $campaign->end_date;

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

        $campaign_id = $request->input('campaign_id');

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',

        ]);


        $payload = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        $endpointUrl = "http://localhost:1064/api/campaign/participate/{$campaign_id}";

        $response = Http::post($endpointUrl,$payload);

        if (!$response->successful()) {
            \Log::error('API Error:', ['response' => $response->json()]);
            return back()->withErrors(['msg' => 'Failed to participate campaign. Check logs for details.'])->withInput();
        }

        if ($response->successful()) {
            return redirect()->route('campaigns.show' , $campaign_id)->with('success', 'participation created successfully.');

        } else {
            return back()->withErrors(['msg' => 'Failed to add participation.'])->withInput();
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
    public function destroy($idCampaign,$idUser)
    {
        $endpointUrl = "http://localhost:1064/api/campaign/participate/delete/${idCampaign}/{$idUser}";

        $response = Http::delete($endpointUrl);

        if ($response->successful()) {
            return redirect()->route('campaigns.index')->with('success', 'participants deleted successfully.');
        } else {
            // Handle errors
            $errorMessage = $response->json()['message'] ?? 'Failed to delete campaign.';
            return redirect()->route('campaigns.index')->withErrors(['msg' => $errorMessage]);
        }
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
