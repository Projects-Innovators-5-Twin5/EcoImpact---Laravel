@extends('profile.layout')

@section('content')
<title>EcoImpact - Campaign participation history page</title>

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/landing.js') }}"></script>

@include('Front.CompagneSensibilisation.modalCancelParticipation')

@section('content')
        <div class="col-10 col-xl-8">
            <div class="card card-body card-participation border-0 shadow mb-4">
                <h2 class="h5">Campaign participation Details</h2>
                <span style="display: block; border-top: 1px solid #ccc; margin: 10px 0;"></span>
                
                <div class="d-flex mt-2">
                    <span class="fw-bold">Campaign title:</span>
                    <span style="margin-left:10px">{{$campaign_participation->campaign->title}}</span>
                </div>

                <div class="d-flex mt-4">
                    <span class="fw-bold">Campaign start date:</span>
                    <span style="margin-left:10px"> <img src="/assets/img/deadline.png" alt="icon" class="icon" style="width:20px; height:20px;">  <span class="text-info fw-bold">{{ $startDate->format('l, F j, Y') }}</span></span>
                </div>

                <div class="d-flex mt-4">
                    <span class="fw-bold">Campaign end date:</span>
                    <span style="margin-left:10px"> <img src="/assets/img/deadline.png" alt="icon" class="icon" style="width:20px; height:20px;">  <span class="text-info fw-bold">{{ $endDate->format('l, F j, Y') }}</span></span>
                </div>
                 
                <div class="d-flex mt-4">
                    <span class="fw-bold">Participation date:</span>
                    <span style="margin-left:10px">{{$campaign_participation->created_at->format('l, F j, Y')}}</span>
                </div>

                <div class="d-flex mt-4">
                    <span class="fw-bold">Participation request:</span>
                        @if ($campaign_participation->status =='accepted')
                        <span style="margin-left:10px"  class="status-active">
                          {{$campaign_participation->status}}
                        </span>
                        @else
                        <span style="margin-left:10px"  class="status-pending">
                          {{$campaign_participation->status}}
                        </span>
                        @endif
                </div>

                <div style="background-image: url('{{ asset('storage/' . $campaign_participation->campaign->image) }}'); background-size: cover; background-position: center; height: 300px; margin-top:40px;"></div>


            </div>

            

          
         
        </div>


@endsection