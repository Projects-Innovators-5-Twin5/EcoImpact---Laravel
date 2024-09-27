@extends('profile.layout')

@section('content')
<title>EcoImpact - Profile User page</title>

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<script src="{{ asset('js/landing.js') }}"></script>


@section('content')
        <div class="col-10 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">General information</h2>
                <form action="#">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="first_name">First Name</label>
                                <input class="form-control" id="first_name" type="text"
                                    placeholder="Enter your first name" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="last_name">Last Name</label>
                                <input class="form-control" id="last_name" type="text"
                                    placeholder="Also your last name" required>
                            </div>
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
                                <input data-datepicker=""
                                    class="form-control datepicker-input" id="birthday" type="text"
                                    placeholder="yyyy/mm/dd" disabled>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender">Gender</label>
                            <select class="form-select mb-0" id="gender"
                                aria-label="Gender select example">
                                <option selected>Gender</option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input  class="form-control" id="email" type="email"
                                    placeholder="name@company.com" disabled>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input class="form-control" id="phone" type="number"
                                    placeholder="+12-345 678 910">
                            </div>
                        </div>
                    </div>
                    <h2 class="h5 my-4">Location</h2>
                    <div class="row">
                        <div class="col-sm-9 mb-3">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input  class="form-control" id="address" type="text"
                                    placeholder="Enter your home address">
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="number">Number</label>
                                <input class="form-control" id="number" type="number"
                                    placeholder="No.">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input class="form-control" id="city" type="text"
                                    placeholder="City">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="zip">ZIP</label>
                                <input class="form-control" id="zip" type="tel" placeholder="ZIP">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end" style="margin-top:50px;">
                        <button type="submit" class="btn btn-gray-800 mt-4 animate-up-2">Save All</button>
                    </div>
                </form>
            </div>
         
        </div>


@endsection