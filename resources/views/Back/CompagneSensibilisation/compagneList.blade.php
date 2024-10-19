@extends('back.layout')
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/compaign.js') }}"></script>


@section('content')
@include('Back.CompagneSensibilisation.createCompagne')
@include('Back.CompagneSensibilisation.modalConfirmationSuppression')


<title>EcoImpact - Awareness Campaigns list page</title>

    <div class="d-block mb-4 mb-md-0 mt-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">EcoImpact</a></li>
                <li class="breadcrumb-item active" aria-current="page">Awareness Campaigns</li>
            </ol>
        </nav>
        <h2 class="h4">All Awareness Campaigns</h2>
        
    </div>

<!--<div class="row d-flex justify-content-center justify-content-around mt-4">
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-info rounded me-4 me-sm-0">
                        <i class="fas fa-calendar-alt" style="font-size: 25px; color: blue;"></i>

                        </div>
                       
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block mt-2">
                            <h2 class="h5 text-info mb-0">Upcoming </h2>
                            <h4 class="fw-bold mt-2 text-info">{{$upcomingCampaignsCount}}</h4>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                            <i class="fas fa-spinner" style="font-size: 30px; color: green; animation: spin 2s linear infinite;"></i>
                        </div>
                 
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block mt-2">
                            <h2 class="h5 text-success mb-0">Active</h2>
                            <h4 class="fw-bold mt-2 text-success">{{$activeCampaignsCount}}</h4>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                        <i class="fas fa-check-circle" style="font-size: 30px; color: orange;"></i>

                        </div>
                    
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block mt-2">
                            <h2 class="h5 complete mb-0">Completed</h2>
                            <h4 class="fw-bold mt-2 complete">{{$completedCampaignsCount}}</h4>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>-->


<div class="btn-toolbar mb-2 mb-md-0 py-4 d-flex justify-content-end">
   <button  class="btn btn-sm btn-gray-800" data-bs-toggle="modal" data-bs-target="#modal-createC-form">
       <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>Add Campaign
   </button>
    <div class="btn-group ms-2 ms-lg-3">
        <a type="button"  href="{{ route('export.pdf') }}" class="btn btn-sm btn-outline-gray-600 export-pdf">Export PDF</a>
    </div>     
    <div class="btn-group ms-2 ms-lg-3">
        <a type="button"  href="{{ route('calendar') }}" class="btn btn-sm btn-outline-gray-600 export-pdf"><i class="fas fa-calendar-alt" style="font-size: 15px;"></i>  Calendar</a>
    </div>     
</div>


   

<div class="table-settings mb-4">
    <div class="row align-items-center justify-content-between">
        <div class="d-flex col col-md-6 col-lg-8 col-xl-8">
            <div class="input-group me-2 me-lg-3 fmxw-400">
                <span class="input-group-text">
                    <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </span>
                <input type="text" class="form-control" id="searchInput" placeholder="Search campaigns">
            </div>
                <select class="form-select fmxw-200 d-none d-md-inline" id="status" name="status" aria-label="Message select example 2">
                    <option value="all">all</option>
                    <option value="active">active</option>
                    <option value="upcoming">upcoming</option>
                    <option value="completed">completed</option>
                    <option value="archived">archived</option>
                </select>
        </div>
        <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
            <div class="dropdown mr-4">
                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
                    <span class="small ps-3 fw-bold text-dark">Show</span>
                    <a class="dropdown-item d-flex align-items-center fw-bold" href="#">10 <svg class="icon icon-xxs ms-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></a>
                    <a class="dropdown-item fw-bold" href="#">20</a>
                    <a class="dropdown-item fw-bold rounded-bottom" href="#">30</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-body border-0 shadow table-wrapper table-responsive">
    <table class="table table-hover" id="campaignList">
        <thead>
            <tr>
                <th class="border-gray-200">Title</th>						
                <th class="border-gray-200">Start Date</th>
                <th class="border-gray-200">End Date</th>
                <th class="border-gray-200">target audience</th>
                <th class="border-gray-200">Status</th>
                <th class="border-gray-200">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Item -->

            @foreach($campaigns as $campaign)
            @php
                $startDate = \Carbon\Carbon::parse($campaign->start_date);
                $endDate = \Carbon\Carbon::parse($campaign->end_date);
            @endphp
            <tr>
              
                <td>
                    <span class="fw-normal">{{ $campaign->title }}</span>
                </td>
                <td><span class="fw-normal">{{ $startDate->format('l, F j, Y')}}</span></td>                        
                <td><span class="fw-normal">{{ $endDate->format('l, F j, Y')}}</span></td>
                    <td>
                        @foreach($campaign->target_audience as $audience)
                            <div class="fw-bold"> {{ $audience }}</div>
                        @endforeach    
                    </td>
                <td>
                    @if ($campaign->status === 'active')
                      <span class="fw-bold status-active">active</span>
                    @elseif($campaign->status  === 'upcoming')
                      <span class="fw-bold status-upcoming">upcoming</span>
                    @elseif($campaign->status === 'completed')
                      <span class="fw-bold status-completed">completed</span>
                    @else
                       <span class="fw-bold status-archived">archived</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon icon-sm">
                                <span class="fas fa-ellipsis-h icon-dark"></span>
                            </span>
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu py-0">
                            <a class="dropdown-item rounded-top" href="{{ route('campaigns.showBack',  $campaign->id) }}"><span class="fas fa-eye me-2" ></span>View Details</a>

                            <a class="dropdown-item" href="{{ route('campaigns.edit',  $campaign->id) }}" ><span class="fas fa-edit me-2" ></span>Edit</a>   

                            <button type="button" class="dropdown-item text-danger rounded-bottom" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal-confirmationsuppression"
                                        data-campaign-id="{{ $campaign->id }}">
                                    <span class="fas fa-trash-alt me-2"></span>Remove
                                </button>                        
                        </div>
                    </div>
                </td>
            </tr>         
            
            @endforeach
                   
        </tbody>
    </table>




    <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
        <nav aria-label="Page navigation example">
            <ul class="pagination mb-0">
        @if ($campaigns->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $campaigns->previousPageUrl() }}" rel="prev">Previous</a>
            </li>
        @endif

        <!-- Pagination Elements -->
        @foreach ($campaigns->links() as $page => $url)
            @if ($campaigns->currentPage() == $page)
                <li class="page-item active">
                    <span class="page-link">{{ $page }}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endif
        @endforeach

        <!-- Next Page Link -->
        @if ($campaigns->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $campaigns->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        @endif
            </ul>
        </nav>

   
        <div class="fw-normal small mt-4 mt-lg-0">Showing <b>5</b> out of <b>{{$completedCampaignsCount + $upcomingCampaignsCount+ $activeCampaignsCount}}</b> entries</div>
    </div>
</div>
@endsection
