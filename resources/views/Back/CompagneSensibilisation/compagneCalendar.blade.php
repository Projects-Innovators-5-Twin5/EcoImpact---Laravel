@extends('back.layout')
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<link href='https://unpkg.com/@fullcalendar/common/main.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/daygrid/main.css' rel='stylesheet' />

@vite(['resources/js/calendar.js']) 




@section('content')
<title>EcoImpact - Awareness Campaign calendar page</title>

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

<div class="card p-4">

<div id="calendar">


</div>
</div>


@endsection
