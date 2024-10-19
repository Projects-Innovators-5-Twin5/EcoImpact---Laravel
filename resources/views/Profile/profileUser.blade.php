@extends('profile.layout')

@section('content')
<title>EcoImpact - Profile User page</title>

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<script src="{{ asset('js/landing.js') }}"></script>


@section('content')
        <div class="col-10 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">General information</h2>
                <form action="{{ route('updateProfile') }}" method="post">
                @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div>
                                <label for="name">Full Name</label>
                                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" type="text"
                                    placeholder="Enter your first name"  value="{{ old('name' ,$user->name) }}">
                            </div>
                            @if ($errors->has('name'))
                                                        @foreach ($errors->get('name') as $error)
                                                            @if ($error == 'The fullname field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-title">Fullname is required</div>
                                                            @elseif ($error == 'The title may not be greater than 255 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-title">The fullname cannot be more than 255 characters long</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-title">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input  class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" 
                                     value="{{ old('email' , $user->email) }}">
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
                        
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3">
                            <label for="birthday">Birthday</label>
                            <div class="input-group">
                                <span class="input-group-text"><svg class="icon icon-xs" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"></path>
                                    </svg></span>
                                    <input data-datepicker=""  class="form-control" id="birthDate" name="birthDate" type="date" value="{{ old('birthDate', $user->birthDate) }}" >   

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" type="number"
                                 value="{{ old('phone' , $user->phone) }}">
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
                    </div>
                   
                    <h2 class="h5 my-4">Location</h2>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input  class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" type="text"
                                    placeholder="Enter your home address" value="{{ old('address' , $user->address) }}">

                            </div>
                            @if ($errors->has('address'))
                                                        @foreach ($errors->get('address') as $error)
                                                            @if ($error == 'The address field is required.')
                                                                <div class="text-danger h6 mt-1" id="error-title">Address is required</div>
                                                            @elseif ($error == 'The address may not be greater than 255 characters.')
                                                                <div class="text-danger h6 mt-1" id="error-title">The address cannot be more than 255 characters long</div>
                                                            @else
                                                                <div class="text-danger h6 mt-1" id="error-title">{{ $error }}</div>
                                                            @endif
                                                        @endforeach
                                                    @endif

                            
                        </div>
                        
                    </div>
                    
                    <div class="d-flex justify-content-end" style="margin-top:185px;">
                        <button type="submit" class="btn btn-gray-800 mt-4 animate-up-2">Save All</button>
                    </div>
                </form>
            </div>
         
        </div>


@endsection