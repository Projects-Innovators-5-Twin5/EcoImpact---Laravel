@extends('back.layout')
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/compaign.js') }}"></script>


@section('content')
@include('Back.CompagneSensibilisation.createCompagne')
@include('Back.CompagneSensibilisation.ModalConfirmationSuppression')


<title>EcoImpact - Awareness Campaign Details page</title>

<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/landing.js') }}"></script>

<div class="d-block mb-4 mb-md-0 mt-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">EcoImpact</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/campaigns">Awareness Campaigns</a></li>
            </ol>
        </nav>        
    </div>

<div class="mt-4">
        <div class="text-center mb-4">
            <h3 style="margin-right:15px;">{{$campaign->title}}</h3>
          
        </div>
</div>

<div style="background-image: url('{{ asset('storage/' . $campaign->image) }}'); background-size: cover; background-position: center; height: 400px; margin-top:30px;">
</div>


   <div class="d-flex">
        <div class="col-10 col-xl-4 mt-4 p-4">
            <div class="row">
                <div class="col-12">
                    <div class="card card-body border-0 shadow mb-4">
                       <p class="mt-2">Join us from <img src="/assets/img/deadline.png" alt="icon" class="icon" style="width:20px; height:20px;">  <span class="text-info fw-bold">{{ $startDate->format('l, F j, Y') }}</span> to <img src="/assets/img/deadline.png" alt="icon" class="icon" style="width:20px; height:20px;">  <span class="text-info fw-bold"> {{ $endDate->format('l, F j, Y') }} </span>  for our exciting campaign</p>
                        
                    </div>
                </div>

                
            </div>
               <div class="col-12">
                    <div class="card card-body border-0 shadow">
                        <h5>Campaign target Audience</h5>
                        <p class="mt-4">This campaign is designed specifically for:
                            <ul>
                              @foreach($campaign->target_audience as $audience)
                               <li>{{$audience}}</li>
                               @endforeach
                            </ul>
                        </p>
                    </div>
                </div>
        </div>

        <div class="col-10 col-xl-8 mt-4 p-4">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Campaign Overview</h2>
                <p class="d-flex align-items-center">{{$campaign -> description}}</p>    
                
                <h2 class="h5 mt-4">Campaign Events</h2>

            </div>
         
        </div>

    </div>
@endsection
