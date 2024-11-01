@extends('front.layout')

@section('content')
<title>EcoImpact - Awareness Campaign List page</title>

<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/landing.js') }}"></script>


<div class="container">
       
        <div class="text">
            <h3 style="margin-right:15px;"><img src="/assets/img/campaign.png" alt="logo" class="icon-compaign" > Explore Our Awareness Campaigns</h3>
            <p>
               Empowering Communities To Act For a Sustainable Future
            </p>
            <form class="navbar-search form-inline" id="navbar-search-main">
                <div class="input-group input-group-merge search-bar">
                    <input type="text" class="form-control" id="topbarInputIconLeft" placeholder="Search" aria-label="Search"
                    aria-describedby="topbar-addon">
                    <span class="input-group-text" id="topbar-addon"><svg class="icon icon-xs"
                        x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                    </svg></span></span>
                </div>
            </form>
        </div>
       
</div>


<div class="list-compaign-active bg-white shadow "> 
    <h2 class="title-list-compaign"></span><img src="/assets/img/active.png" alt="icon" class="icon" style="width:25px; height:25px;">   Active campaigns</h2>

    <div class="active-compaign d-flex flex-wrap justify-content-start">

       @foreach($activeCampaigns as $campaign)
        <div class="card mt-4" style="width: 25rem; height:20rem; margin-left:90px;cursor:pointer;" onclick="window.location='{{ route('campaigns.show', ['id' => $campaign->idCampaign] ) }}'";>
               @if($campaign->image)
                  <img src="{{ asset('storage/' . $campaign->image) }}" alt="Image" class="card-img-top img-c">
                @endif
                <div class="card-body">
                    <h5 class="card-title" style="text-transform:capitalize;">{{ $campaign->title }}</h5>
                    <p class="card-text">{{ Str::limit($campaign->description, 100, '...') }}</p>
                </div>
        </div>
        @endforeach
    </div>    

</div>


<div class="list-compaign-upcoming shadow "> 
    <h2 class="title-list-compaign"> <img src="/assets/img/upcoming.png" alt="icon" class="icon" style="width:25px; height:25px;">    Upcoming campaigns</h2>

    <div class="upcoming-compaign d-flex flex-wrap justify-content-start sm:items-center">

       @foreach($upcomingCampaigns as $campaign)
        <div class="card mt-4" style="width: 25rem; height:20rem; margin-left:90px;cursor:pointer;" onclick="window.location='{{ route('campaigns.show', ['id' => $campaign->idCampaign] ) }}'";>
               @if($campaign->image)
                  <img src="{{ asset('storage/' . $campaign->image) }}" alt="Image" class="card-img-top img-c">
                @endif
                <div class="card-body">
                    <h5 class="card-title" style="text-transform:capitalize;">{{ $campaign->title }}</h5>
                    <p class="card-text">{{ Str::limit($campaign->description, 100, '...') }}</p>
                </div>
        </div>
        @endforeach
    </div>    

</div>



<div class="list-compaign-upcoming bg-white shadow "> 
    <h2 class="title-list-compaign"><img src="/assets/img/completed.png" alt="icon" class="icon" style="width:25px; height:25px;">   Recently completed campaigns</h2>

    <div class="upcoming-compaign d-flex flex-wrap justify-content-start">

       @foreach($completedCampaigns as $campaign)


        <div class="card mt-4" style="width: 25rem; height:20rem; margin-left:90px;cursor:pointer;" onclick="window.location='{{route('campaigns.show', ['id' => $campaign->idCampaign] )}}'";>
               @if($campaign->image)
                  <img src="{{ asset('storage/' . $campaign->image) }}" alt="Image" class="card-img-top img-c">
                @endif
                <div class="card-body">
                    <h5 class="card-title" style="text-transform:capitalize;">{{ $campaign->title }}</h5>
                    <p class="card-text">{{ Str::limit($campaign->description, 100, '...') }}</p>
                </div>
        </div>
        @endforeach
    </div>    

</div>

@endsection