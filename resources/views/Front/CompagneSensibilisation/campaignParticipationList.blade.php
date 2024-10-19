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
                <h2 class="h5 mb-4">Campaign participation</h2>
                <table class="table table-hover" id="participationList">
                    <thead>
                        <tr>
                            <th class="border-gray-200">Campaign name</th>						
                            <th class="border-gray-200">Date created</th>
                            <th class="border-gray-200">Status</th>
                            <th class="border-gray-200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Item -->

                        @foreach($participations as $participation)
                        <tr>
                            
                            <td>
                                <span class="fw-normal">{{ $participation->campaign->title }}</span>
                            </td>
                            <td>
                                <span class="fw-normal">{{ $participation->created_at->format('l, F j, Y') }}</span>
                            </td>
                            <td>
                                @if ($participation->status === 'pending')
                                <span class="fw-bold status-pending">pending</span>
                                @elseif($participation->status  === 'accepted')
                                <span class="fw-bold status-active">accepted</span>
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
                                        <a class="dropdown-item" href="#" ><span class="fas fa-edit me-2" ></span>Edit</a>   
                                        <button type="button" class="dropdown-item text-danger rounded-bottom" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modal-confirmationcancel-participant"
                                                    data-participant-id="{{ $participation->id }}">
                                                <span class="fas fa-trash-alt me-2"></span>Cancel
                                            </button>                        
                                    </div>
                                </div>
                            </td>
                        </tr>         
                        
                        @endforeach
                            
                    </tbody>
                </table>
            </div>

          
         
        </div>


@endsection