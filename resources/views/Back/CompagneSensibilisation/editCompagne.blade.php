@extends('back.layout')
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/compaign.js') }}"></script>


@section('content')

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

<div class=" p-0 d-flex justify-content-center ">
<div class="card col-md-12  p-3 p-lg-4">
<div class="text-start text-md-start mb-4 mt-md-0">
                                                <h1 class="mb-0 h4">Edit Campaign</h1>
                                            </div>
                                           
                                            <form action="{{ route('campaigns.update' ,$campaign->id) }}"  method="POST" enctype="multipart/form-data">

                                                @csrf
                                                @method('PUT')
                                                <!-- Form -->
                                                <div class="form-group mb-4">
                                                    <label for="title">Title</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="title" value="{{ old('title', $campaign->title) }}" placeholder="Enter Title" id="title" autofocus >
                                                    </div>  
                                                </div>
                                              
                                                <div class="form-group mb-4">
                                                    <label for="start_date">Start Date</label>
                                                    <div class="input-group">
                                                      
                                                       <input data-datepicker="" class="form-control" id="start_date" value="{{ old('start_date', $campaign->start_date) }}" name="start_date" type="date" placeholder="dd/mm/yyyy" >   
                                                
                                                    </div>  
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="end_date">End Date</label>
                                                    <div class="input-group">
                                                       <input data-datepicker="" class="form-control" id="end_date" type="date" value="{{ old('end_date', $campaign->end_date) }}" name="end_date" placeholder="dd/mm/yyyy" >   
                                                      
                                                    </div>  
                                                </div>


                                            
                                                <div class="form-group mb-4">
                                                  
                                                    <label for="image" class="form-label">Image</label>
                                                    <input class="form-control" name="image"  type="file" id="image">
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="target_audience">Target audience</label>

                                                    <div class="input-group">
                                                    <select class="form-select" id="target_audience" name="target_audience[]" aria-label="Default select example" multiple>
                                                        @foreach (['Grand Public', 'Jeunes et Etudiants', 'Professionnels et Travailleurs', 'Institutions et Organisations', 'Communautes Locales'] as $option)
                                                        <option value="{{ $option }}" {{ in_array($option, $campaign->target_audience ) ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    </div>  
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="target_audience">Status</label>

                                                    <div class="input-group">

                                                        <select class="form-select" id="status" name="status" aria-label="Message select example 2">
                                                            @if($campaign->status == 'active')
                                                              <option value="active" selected>active</option>
                                                              <option value="upcoming">upcoming</option>
                                                              <option value="completed">completed</option>
                                                              <option value="archived">archived</option>
                                                            @elseif($campaign->status == 'upcoming')  
                                                               <option value="active">active</option>
                                                               <option value="upcoming" selected>upcoming</option>
                                                               <option value="completed">completed</option>
                                                               <option value="archived">archived</option>
                                                            @elseif($campaign->status == 'completed')  
                                                                <option value="active">active</option>
                                                                <option value="upcoming">upcoming</option>
                                                                <option value="completed" selected>completed</option>
                                                                <option value="archived">archived</option>
                                                            @else  
                                                                <option value="active">active</option>
                                                                <option value="upcoming">upcoming</option>
                                                                <option value="completed">completed</option>
                                                                <option value="archived" selected>archived</option>
                                                            @endif   
                                                        </select>
                                                    </div>  
                                                </div>


                                                <div class="form-group mb-4">
                                                    <label for="description">Description</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="description" placeholder="Enter description..."  id="description" rows="4">{{ old('description', $campaign->description) }}</textarea>
                                                    </div>  
                                                </div>


                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-gray-800">Submit</button>
                                                </div>
                                            </form> 
                                        </div>                                      
</div>

                                   
                            

@endsection