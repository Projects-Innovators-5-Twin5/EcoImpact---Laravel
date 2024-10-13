@extends('back.layout')
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
<script src="{{ asset('js/compaign.js') }}"></script>
<script src="{{ asset('js/participation.js') }}"></script>
<script src="{{ asset('js/landing.js') }}"></script>


@section('content')
@include('Back.CompagneSensibilisation.createCompagne')
@include('Back.CompagneSensibilisation.modalConfirmationSuppParticipant')
@include('Back.CompagneSensibilisation.modalParticipantDetails')


<title>EcoImpact - Awareness Campaign Details page</title>


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
                            <div class="d-flex justify-content-center align-items-center mt-2">
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
            </div>

        </div>

    </div>


    <div class="table-settings mb-4">
    <div class="row align-items-center justify-content-between">
    <h2 class="h3 mb-4 mt-4">Participants List</h2>

        <div class="d-flex col col-md-6 col-lg-8 col-xl-8">
            <div class="input-group me-2 me-lg-3 fmxw-400">
                <span class="input-group-text">
                    <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </span>
                <input type="hidden" id="campaignId" value="{{ $campaign->id }}">
                <input type="text" class="form-control" id="searchInputP" placeholder="Search participants">
            </div>
                <select class="form-select fmxw-200 d-none d-md-inline" id="statusP" name="statusP" aria-label="Message select example 2">
                    <option value="all">all</option>
                    <option value="pending">pending</option>
                    <option value="accepted">accepted</option>
                    <option value="rejected">rejected</option>
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
    <table class="table table-hover" id="participationList">
        <thead>
            <tr>
                <th class="border-gray-200">Name</th>						
                <th class="border-gray-200">Email</th>
                <th class="border-gray-200">Phone</th>
                <th class="border-gray-200">Date created</th>
                <th class="border-gray-200">Status</th>
                <th class="border-gray-200">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Item -->

            @foreach($campaigns_participations as $campaign_participation)
            <tr>
                
                <td>
                    <span class="fw-normal">{{ $campaign_participation->name }}</span>
                </td>
                <td>
                    <span class="fw-normal">{{ $campaign_participation->email }}</span>
                </td>
                <td>
                    <span class="fw-normal">{{ $campaign_participation->phone }}</span>
                </td>
                <td>
                    <span class="fw-normal">{{ $campaign_participation->created_at->format('l, F j, Y') }}</span>
                </td>
                <td>
                    @if ($campaign_participation->status === 'pending')
                      <span class="fw-bold status-pending">pending</span>
                    @elseif($campaign_participation->status  === 'accepted')
                      <span class="fw-bold status-active">accepted</span>
                    @elseif($campaign_participation->status === 'rejected')
                      <span class="fw-bold status-archived">rejected</span>
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
                            <a class="dropdown-item rounded-top" data-bs-toggle="modal" data-bs-target="#modal-default"  data-namep="{{$campaign_participation->name }}" data-phonep="{{$campaign_participation->phone }}" data-emailp="{{$campaign_participation->email }}" data-reasonsp="{{$campaign_participation->reasons }}" data-participant-id="{{$campaign_participation->id}}" data-statusp="{{$campaign_participation->status}}"><span class="fas fa-eye me-2" ></span>View Details</a>

                            <button type="button" class="dropdown-item text-danger rounded-bottom" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal-confirmationsuppression-participant"
                                        data-participant-id="{{ $campaign_participation->id }}">
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
        @if ($campaigns_participations->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{  $campaigns_participations ->previousPageUrl() }}" rel="prev">Previous</a>
            </li>
        @endif

        <!-- Pagination Elements -->
        @foreach ($campaigns_participations->links() as $page => $url)
            @if ($campaigns_participations->currentPage() == $page)
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
        @if ($campaigns_participations ->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{  $campaigns_participations ->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        @endif
            </ul>
        </nav>

       </div>
</div>
@endsection
