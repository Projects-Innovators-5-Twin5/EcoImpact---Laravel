@extends('back.layout')
<title>EcoImpact - Challenges</title>

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
                <li class="breadcrumb-item active" aria-current="page">Challenges</li>
            </ol>
        </nav>
        <h2 class="h4">All Challenges </h2>
        
    </div>

<br>
          <div class="input-group input-group-merge search-bar">
            <span class="input-group-text" id="topbar-addon"><svg class="icon icon-xs"
                x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"></path>
              </svg></span></span>
              <input type="text" id="search" class="form-control" placeholder="Search challenges..." value="{{ $search }}">

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
                <tbody id="challengesTableBody"> <!-- Set an ID for the table body -->
                    @include('Back.Challenges.table_rows', ['challenges' => $challenges]) <!-- Include a separate view for table rows -->
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
        {{ $challenges->links('pagination::bootstrap-4') }} <!-- Using Bootstrap pagination -->
    </div>
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

    // Live search function
    document.getElementById('search').addEventListener('input', function () {
    const searchTerm = this.value;

    // Make an AJAX request to the server to fetch search results
    fetch(`{{ route('challenges.index') }}?search=${searchTerm}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // Ensure it is recognized as an AJAX request
        }
    })
    .then(response => {
        if (response.ok) {
            return response.text();
        }
        throw new Error('Network response was not ok.');
    })
    .then(html => {
        // Update the table body with the new HTML
        document.getElementById('challengesTableBody').innerHTML = html;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
});

</script>

@endsection
