@extends('profile.layout')

@section('content')
<title>EcoImpact - Campaign participation history page</title>

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/landing.js') }}"></script>

@section('content')
        <div class="col-10 col-xl-8">
            <div class="card card-body card-participation border-0 shadow mb-4">
                <h2 class="h5">Edit campaign participation</h2>
                <span style="display: block; border-top: 1px solid #ccc; margin: 10px 0;"></span>


                <form action="{{ route('participation.update' ,$campaign_participation->id ) }}" class="col-xl-12 mt-2"  method="POST" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="name">Full name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Enter your full name"  value="{{ old('name', $campaign_participation->user->name) }}"  id="name" autofocus readonly>
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
                                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" placeholder="Enter your email" value="{{ old('email', $campaign_participation->user->email) }}" id="email" autofocus readonly>
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
                                        <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" placeholder="Enter your phone" value="{{ old('phone',  $campaign_participation->user->phone) }}" id="phone" autofocus readonly>
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
                                        <textarea  class="form-control {{ $errors->has('reasons') ? 'is-invalid' : '' }}" name="reasons" placeholder="Enter your reasons to join our campaign..." id="reasons" rows="4">{{ old('reasons', $campaign_participation->reasons) }}</textarea>
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


                                <div class="d-grid d-flex justify-content-end" style="margin-top:200px;">
                                    <button type="submit" class="btn btn-gray-800">Submit</button>
                                </div>
                                </form> 
                                            </div>

                                        
                                        
                                        </div>


@endsection