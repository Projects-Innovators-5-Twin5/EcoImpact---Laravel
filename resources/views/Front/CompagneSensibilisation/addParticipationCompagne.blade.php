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


<div class="d-flex">

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
            <div class="card card-body border-0 shadow mb-4 d-flex justify-content-center align-items-center ">
                <h2 class="h3 mb-4 text-center">Participation Form</h2>
                <form action="{{ route('participation.store') }}" class="col-xl-10"  method="POST" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                <!-- Form -->
                <div class="form-group mb-4">
                    <label for="name">Full name</label>
                    <div class="input-group">
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Enter your full name" value="{{ old('name') }}" id="name" autofocus>
                    </div>  
                    @if ($errors->has('name'))
                            @foreach ($errors->get('name') as $error)
                                    @if ($error == 'The name field is required.')
                                        <div class="text-danger h6 mt-1" id="error-title">Full name is required</div>
                                    @else
                                        <div class="text-danger h6 mt-1" id="error-title">{{ $error }}</div>
                                    @endif
                             @endforeach
                    @endif
                </div>


                <div class="form-group mb-4">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" placeholder="Enter your email" value="{{ old('email') }}" id="email" autofocus>
                    </div>  

                    @if ($errors->has('email'))
                        @foreach ($errors->get('email') as $error)
                            @if ($error == 'The email field is required.')
                                <div class="text-danger h6 mt-1" id="error-email">Email is required</div>
                            @elseif ($error == 'The email must be a valid email address.')
                                <div class="text-danger h6 mt-1" id="error-email">Please provide a valid email address</div>
                            @else
                                <div class="text-danger h6 mt-1" id="error-email">{{ $error }}</div>
                            @endif
                        @endforeach
                    @endif
                   
                </div>

                <div class="form-group mb-4">
                    <label for="phone">Phone</label>
                    <div class="input-group">
                        <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" placeholder="Enter your phone" value="{{ old('phone') }}" id="phone" autofocus>
                    </div>  

                    @if ($errors->has('phone'))
                        @foreach ($errors->get('phone') as $error)
                            @if ($error == 'The phone field is required.')
                                <div class="text-danger h6 mt-1" id="error-phone">Phone number is required</div>
                            @elseif (str_contains($error, 'digits'))
                                <div class="text-danger h6 mt-1" id="error-phone">Phone number must be exactly 8 digits, you entered {{ old('phone') }}</div>
                            @else
                                <div class="text-danger h6 mt-1" id="error-phone">{{ $error }}</div>
                            @endif
                        @endforeach
                    @endif

                   
                </div>


                <div class="form-group mb-4">
                    <label for="reasons">Reasons to join our campaign</label>
                    <div class="input-group">
                        <textarea  class="form-control {{ $errors->has('reasons') ? 'is-invalid' : '' }}" name="reasons" placeholder="Enter your reasons to join our campaign..." id="reasons" rows="2">{{ old('reasons') }}</textarea>
                    </div>  
                    @if ($errors->has('reasons'))
                                                        @foreach ($errors->get('reasons') as $error)
                                                            @if ($error == 'The reasons field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-description">Reasons to join our campaign is required</div>
                                                            @elseif ($error == 'The reasons must be at least 100 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-description">The Reasons to join our campaign must be at least 100 characters long</div>
                                                            @elseif ($error == 'The reasons may not be greater than 1000 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-description">The Reasons to join our campaign cannot be more than 1000 characters long</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-description">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif                    
                </div>
                
                <input type="hidden" id="error-exist" value="{{ $errors->any() ? 'true' : 'false' }}">


                <div class="d-grid d-flex justify-content-end">
                    <button type="submit" class="btn btn-gray-800 col-md-2">Submit</button>
                </div>
                </form> 


        </div>


</div>

@endsection