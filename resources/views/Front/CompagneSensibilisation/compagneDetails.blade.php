@extends('front.layout')

@section('content')
<title>EcoImpact - Awareness Campaign Details page</title>

<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/landing.js') }}"></script>


<div class="mt-4">
        <div class="text-center mb-4">
            <h3 style="margin-right:15px;">{{$campaign->title}}</h3>
          
        </div>
</div>

<div style="background-image: url('{{ asset('storage/' . $campaign->image) }}'); background-size: cover; background-position: center; height: 400px; margin-top:30px;">
</div>


    <div class="d-flex block_details">
        <div class="col-10 col-xl-4 mt-4 p-4">
                <div class="col-12">
                    <div class="card card-body border-0 shadow mb-4">
                       <p class="mt-2">Join us from <img src="/assets/img/deadline.png" alt="icon" class="icon" style="width:20px; height:20px;">  <span class="text-info fw-bold">{{ $startDate->format('l, F j, Y') }}</span> to <img src="/assets/img/deadline.png" alt="icon" class="icon" style="width:20px; height:20px;">  <span class="text-info fw-bold"> {{ $endDate->format('l, F j, Y') }} </span>  for our exciting campaign</p>
                        
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

                <div class="col-12 mt-4">
                    <div class="card card-body border-0 shadow">
                        <h5 class="text-center">Follow Us on Social Media</h5>
                        <div class="d-flex justify-content-center align-items-center mt-4">
                                <span>
                                    <a class="btn btn-outline btn-floating m-1" href="{{ $campaign->link_fb ?: '#' }}"  target="{{ $campaign->link_fb ? '_blank' : '_self' }}" >
                                        <i class="fab fa-facebook-f"></i></a>
                                    </a>
                               </span>
                                <span>
                                    <a  class="btn btn-outline btn-floating m-1" href="{{ $campaign->link_insta ?: '#' }}" target="{{ $campaign->link_insta ? '_blank' : '_self' }}"  >
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </span>
                                <span>
                                    <a class="btn btn-outline btn-floating m-1"  href="{{ $campaign->link_web ?: '#' }}" target="{{ $campaign->link_web ? '_blank' : '_self' }}" >
                                        <i class="fas fa-globe"></i>
                                    </a>
                                </span>
                            </div>
                    </div>
                </div>
        </div>

        <div class="col-10 col-xl-8 mt-4 p-4">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Campaign Overview</h2>
                <p class="d-flex align-items-center"><span class="text-des">{{$campaign -> description}}</span></p>    
                
                <h2 class="h5 mb-4 mt-4">Join Our Campaign! 🌟</h2>
                <p class="d-flex align-items-center"><span class="text-des">{{$campaign -> reasons_join_campaign}}</span></p>
                <div class="d-flex justify-content-end">
                   <button class="btn btn-secondary btn-join " type="button"><a href="{{route('participation.create' , $campaign->id) }}" class="text-btn" style="color:white;" >Join the Campaign!</a></button>
                </div>   

            </div>

        </div>

    </div>



@endsection