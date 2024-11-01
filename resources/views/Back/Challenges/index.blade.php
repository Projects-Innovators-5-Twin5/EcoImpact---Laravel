@extends('back.layout')
<title>EcoImpact - Challenges</title>

@section('content')

<div class="d-block mb-4 mb-md-0 mt-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#">EcoImpact</a></li>
            <li class="breadcrumb-item active" aria-current="page">Challenges</li>
        </ol>
    </nav>
    <h2 class="h4">All Challenges</h2>
</div>

<br>
<div class="input-group input-group-merge search-bar">
    <span class="input-group-text" id="topbar-addon">
        <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
        </svg>
    </span>
    <input type="text" id="search" class="form-control" placeholder="Search challenges..." value="{{ request('search') }}">
</div>

<br>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <div class="button-group" style="float: right;">
                    <a href="{{ route('challenges.create') }}" class="btn btn-primary">Create New Challenge</a>
                    <a href="{{ route('challenges.export.pdf') }}" class="btn btn-secondary">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>
                <br>
                <thead class="thead-light">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reward Points</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="challengesTableBody">
                    @foreach ($challenges as $challenge)
                        <tr>
                            <td>{{ $challenge['title'] }}</td>
                            <td>{{ Str::limit($challenge['description'], 20) }}</td>
                            <td>{{ \Carbon\Carbon::parse($challenge['start_date'])->format('d/m/Y, H:i:s') }}</td>
                            <td>{{ \Carbon\Carbon::parse($challenge['end_date'])->format('d/m/Y, H:i:s') }}</td>
                            <td>{{ $challenge['rewardPoints'] }}</td>
                            <td>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $challenge['id'] }}" onclick="populateViewModal('{{ $challenge['id'] }}', '{{ $challenge['title'] }}', '{{ $challenge['description'] }}', '{{ $challenge['start_date'] }}', '{{ $challenge['end_date'] }}', {{ $challenge['rewardPoints'] }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('challenges.edit', $challenge['id']) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $challenge['id'] }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <a href="{{ route('challenges.show', $challenge['id']) }}" class="btn btn-success">
                                    <i class="fas fa-list"></i>
                                </a>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $challenge['id'] }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $challenge['id'] }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $challenge['id'] }}">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete the challenge "<strong>{{ $challenge['title'] }}</strong>"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('challenges.destroy', $challenge['id']) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal{{ $challenge['id'] }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $challenge['id'] }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel{{ $challenge['id'] }}">Challenge Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="image-framecard">
                                                    <img src="{{ asset('storage/' . $challenge['image']) }}" alt="Challenge Image" class="img-fluid challenge-image" />
                                                </div>
                                                <strong>Title:</strong> <span id="viewTitle{{ $challenge['id'] }}">{{ $challenge['title'] }}</span><br>
                                                <strong>Description:</strong> {{ Str::limit($challenge['description'], 50, '...') }}<br>
                                                <strong>Start Date:</strong> <span id="viewStartDate{{ $challenge['id'] }}">{{ $challenge['start_date'] }}</span><br>
                                                <strong>End Date:</strong> <span id="viewEndDate{{ $challenge['id'] }}">{{ $challenge['end_date'] }}</span><br>
                                                <strong>Reward Points:</strong> <span id="viewRewardPoints{{ $challenge['id'] }}">{{ $challenge['rewardPoints'] }}</span><br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          
        </div>
    </div>
</div>

<!-- JavaScript to Populate the View Modal -->
<script>
    function populateViewModal(challengeId, title, description, startDate, endDate, rewardPoints) {
        document.getElementById('viewTitle' + challengeId).textContent = title;
        document.getElementById('viewDescription' + challengeId).textContent = description;
        document.getElementById('viewStartDate' + challengeId).textContent = startDate;
        document.getElementById('viewEndDate' + challengeId).textContent = endDate;
        document.getElementById('viewRewardPoints' + challengeId).textContent = rewardPoints;
    }
</script>

@endsection
