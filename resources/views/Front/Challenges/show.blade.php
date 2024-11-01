
@extends('front.layout')

<title>EcoImpact - Challenges</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div id="alert-container" class="mt-3"></div>
<div class="challenge-container">
    <div class="challenge-header">
    <div class="button-group">
    <h5 class="card-title">{{ $challenge['titleChallenge'] }}</h5>

            <a href="{{ route('challenges.indexfront') }}" class="btn btn-secondary back-btn">Back to Challenges</a>
            <button class="btn btn-primary add-solution-btn" onclick="toggleAddSolutionSection()">Add Solution</button>



                     </div>
    </div>

    <div class="challenge-content">
        <div class="image-frame">

        <img src="{{ asset('storage/' . $challenge['imageChallenge']) }}" alt="Challenge Image" class="img-fluid challenge-image" />
        </div>
        <div class="challenge-details">
        <p><strong>Description:</strong> {{ $challenge['descriptionChallenge'] }}</p>
            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($challenge['start_dateChallenge'])->format('d-m-Y H:i') }}</p>
            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($challenge['end_dateChallenge'])->format('d-m-Y H:i') }}</p>
            <p><strong>Time Left:</strong> <span id="time-left"></span></p> <!-- Updated for real-time -->
            <p><strong>Reward Points:</strong> {{ $challenge['rewardPoints'] }}</p>
        </div>
    </div>
    <div id="addSolutionSection" style="display: {{ old('form_type') === 'add_solution' && $errors->any() ? 'block' : 'none' }};">

    <h3>Add a Solution</h3>
    <form id="solutionForm" action="{{ route('solutions.store', $challenge['idChallenge']) }}" method="POST">

    @csrf
    <input type="hidden" name="form_type" value="add_solution">
    <input type="hidden" name="challenge_id" value="{{ $challenge['idChallenge'] }}">

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" placeholder="Enter Title" value="{{ old('title') }}" id="title" autofocus>
        @if ($errors->has('title'))
            <div class="text-danger h6 mt-1" id="error-title">{{ $errors->first('title') }}</div>
        @endif
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" placeholder="Enter description..." id="description" rows="4">{{ old('description') }}</textarea>
        @if ($errors->has('description'))
            <div class="text-danger h6 mt-1" id="error-description">{{ $errors->first('description') }}</div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Add Solution</button>
</form>
</div>




<div class="solution-list">
    <h3 class="mb-4">Solutions</h3>

    @foreach($challenge['solutions'] as $solution)
        <div class="solution-item card mb-3">
            <div class="solution-header d-flex justify-content-between align-items-center p-3">
                <h5 class="mb-0">{{ $solution['title'] }}</h5>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        &#x2026;
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#" onclick="editSolution({{ $solution['id'] }})">Edit</a></li>
                        <li>
                        <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('delete-solution-{{ $solution['id'] }}').submit();">Delete</a>

        </li>

                    </ul>
                </div>
                <form id="delete-solution-{{ $solution['id'] }}" action="{{ route('solutions.destroy', $solution['id']) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

            </div>

            <div class="solution-content p-3">
                <p><strong>Description:</strong> {{ $solution['description'] }}</p>
                <form action="{{ route('solutions.update', $solution['id']) }}" method="POST" style="display:none;" id="edit-form-{{ $solution['id'] }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_type" value="edit_solution">
                    <input type="hidden" name="solution_id" value="{{ $solution['id'] }}">

                    <div class="form-group">
                        <label for="edit-title">Title</label>
                        <input type="text" name="title" value="{{ old('title', $solution['title']) }}" class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit-description">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $solution['description']) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Solution</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEdit({{ $solution['id'] }})">Cancel</button>
                </form>
            </div>
        </div>

    @endforeach

</div>










    <link rel="stylesheet" href="{{ asset('css/challenge.css') }}">
    <link rel="stylesheet" href="{{ asset('css/solution.css') }}">
</div>

<script>
  // Toggle Add Solution section visibility
function toggleAddSolutionSection() {
    const addSolutionSection = document.getElementById('addSolutionSection');
    addSolutionSection.style.display = addSolutionSection.style.display === 'none' || addSolutionSection.style.display === '' ? 'block' : 'none';
}

// Toggle Edit Solution section visibility
function editSolution(solutionId) {
    const editForm = document.getElementById(`edit-form-${solutionId}`);
    editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';

    // Hide other edit forms
    const allEditForms = document.querySelectorAll('.solution-content form');
    allEditForms.forEach(form => {
        if (form !== editForm) {
            form.style.display = 'none';
        }
    });
}

// Cancel edit and hide form
function cancelEdit(solutionId) {
    const editForm = document.getElementById(`edit-form-${solutionId}`);
    editForm.style.display = 'none';
}
// Check for validation errors after the page loads and ensure the edit form with errors is visible
document.addEventListener('DOMContentLoaded', function () {
    const errorSolutionId = "{{ old('solution_id') }}"; // The solution ID that had errors

    if (errorSolutionId) {
        const editForm = document.getElementById(`edit-form-${errorSolutionId}`);
        if (editForm) {
            editForm.style.display = 'block';
        }
    }
});






function showAlert(message, type) {
    const alertContainer = document.getElementById('alert-container');
    const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show small-alert" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    alertContainer.innerHTML = alertHTML;

    setTimeout(() => {
        const alertNode = document.querySelector('.alert');
        if (alertNode) {
            alertNode.classList.remove('show');
            alertNode.addEventListener('transitionend', () => alertNode.remove());
        }
    }, 3000);
}
function voteSolution(solutionId) {
    fetch(`/solutions/${solutionId}/vote`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        const voteButton = document.querySelector(`.vote-btn[data-solution-id="${solutionId}"]`);
        const voteCountSpan = document.querySelector(`#vote-count-${solutionId}`); // Ensure you have this span for displaying the count

        // Update button style and vote count
        voteButton.classList.toggle('voted'); // Add a class for styling (e.g., yellow color)
        voteCountSpan.textContent = data.voteCount; // Update vote count

        showAlert(data.message, 'success'); // Assuming you have a showAlert function
    })
    .catch(error => {
        console.error('Error voting for the solution:', error);
    });
}


function sortSolutions() {
    const sortValue = document.getElementById('solutionSort').value;
    const url = new URL(window.location.href);
    url.searchParams.set('sort', sortValue);
    window.location.href = url.toString();
}


    // Get the end date from the PHP variable
    const endDate = new Date("{{ $challenge['end_dateChallenge'] }}").getTime();

    // Function to calculate the time left and update the DOM
    function updateCountdown() {
        const now = new Date().getTime();
        const timeRemaining = endDate - now;

        // If time has expired, display 'Closed'
        if (timeRemaining <= 0) {
            document.getElementById('time-left').innerHTML = 'Closed';
            return;
        }

        // Calculate days, hours, minutes, and seconds remaining
        const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        // Update the DOM with the remaining time
        document.getElementById('time-left').innerHTML =
            days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
    }

    // Update the countdown every second
    setInterval(updateCountdown, 1000);

    // Initial call to display the countdown immediately
    updateCountdown();






</script>

@endsection
