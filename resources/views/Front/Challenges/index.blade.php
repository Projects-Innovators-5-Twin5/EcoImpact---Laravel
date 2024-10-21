@extends('front.layout')
<title>EcoImpact - Challenges</title>

@section('content')
<div class="container">
    
    <div class="text">
        <h2>🌱 Empower Your Energy Choices 🌞</h2>
        <p>
            Welcome to our Challenges section, where we invite you to engage in meaningful initiatives that promote sustainability and energy efficiency. By participating in these challenges, you contribute to a collective effort to measure, reduce, and sustain our energy consumption. Join us in making a positive impact on our environment while enhancing your skills and creativity. Explore the challenges below and take the first step towards empowering your energy choices!
        </p>
        <form class="navbar-search form-inline" id="navbar-search-main">
            <div class="input-group input-group-merge search-bar">
                <input type="text" id="search" class="form-control" placeholder="Search challenges..." value="{{ $search }}">
                
                <!-- Add the status filter dropdown next to the search input -->
                <select id="statusFilter" class="form-select">
                    <option value="">All Challenges</option>
                    <option value="open" {{ $statusFilter == 'open' ? 'selected' : '' }}>Open Challenges</option>
                    <option value="closed" {{ $statusFilter == 'closed' ? 'selected' : '' }}>Closed Challenges</option>
                    <option value="upcoming" {{ $statusFilter == 'upcoming' ? 'selected' : '' }}>Upcoming Challenges</option>
                </select>
            </div>
        </form>
        <div class="mt-3">
          <a href="/leaderboard" class="btn btn-primary">Go to Leaderboard</a>
         </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="row" id="challengesTableBody">
            @include('Front.Challenges.challenges_list', ['challenges' => $challenges])
        </div>
    </div>
    
    <!-- Add pagination links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $challenges->links('pagination::bootstrap-4') }} <!-- Using Bootstrap pagination -->
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/challenge.css') }}">

<script>
    // Live search function
    document.getElementById('search').addEventListener('input', function () {
        const searchTerm = this.value;
        filterChallenges(searchTerm, document.getElementById('statusFilter').value);
    });

    // Filter by status function
    document.getElementById('statusFilter').addEventListener('change', function () {
        const statusFilter = this.value;
        filterChallenges(document.getElementById('search').value, statusFilter);
    });

    function filterChallenges(searchTerm, statusFilter) {
        // Make an AJAX request to the server to fetch filtered results
        fetch(`{{ route('challenges.indexfront') }}?search=${searchTerm}&status=${statusFilter}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
    if (response.ok) {
        return response.json(); // Change this to parse JSON response
    }
    throw new Error('Network response was not ok.');
})
.then(data => {
    // Update the table body with the new HTML
    document.getElementById('challengesTableBody').innerHTML = data.html;

    // Update the pagination links as well
    document.querySelector('.d-flex.justify-content-center').innerHTML = data.pagination; // Adjust as needed
})

    }
</script>

@endsection


{{--
<div class="container-fluid">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- First Carousel Item -->
            <div class="carousel-item active">
                <img src="/assets/img/carouselchallenge1.png" class="d-block w-100" alt="Cover Image 1" style="height: 60vh; object-fit: cover;">
            </div>
            <!-- Second Carousel Item -->
            <div class="carousel-item">
                <img src="/assets/img/carouselchallenge2.png" class="d-block w-100" alt="Cover Image 2" style="height: 60vh; object-fit: cover;">
            </div>
            <!-- Third Carousel Item -->
            <div class="carousel-item">
                <img src="/assets/img/carouselchallenge3.png" class="d-block w-100" alt="Cover Image 3" style="height: 60vh; object-fit: cover;">
            </div>
        </div>
        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        <!-- Search Input Centered on Carousel -->
        <div class="carousel-caption d-flex justify-content-center align-items-center" style="top: 50%; transform: translateY(-50%);">
            <form class="navbar-search form-inline" id="navbar-search-main">
                <div class="input-group input-group-merge search-bar">
                    <input type="text" id="search" class="form-control" placeholder="Search challenges..." value="{{ $search }}">
                    <select id="statusFilter" class="form-select" style="width">
                        <option value="">All Challenges</option>
                        <option value="open" {{ $statusFilter == 'open' ? 'selected' : '' }}>Open Challenges</option>
                        <option value="closed" {{ $statusFilter == 'closed' ? 'selected' : '' }}>Closed Challenges</option>
                        <option value="upcoming" {{ $statusFilter == 'upcoming' ? 'selected' : '' }}>Upcoming Challenges</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

 
</div>
 --}}
