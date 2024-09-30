
@extends('front.layout')

<title>EcoImpact - Challenges</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@section('content')
<div id="alert-container" class="mt-3"></div>
<div class="challenge-container">
    <div class="challenge-header">
        <h1>{{ $challenge->title }}</h1>
        <div class="button-group">
            <a href="{{ route('challenges.indexfront') }}" class="btn btn-secondary back-btn">Back to Challenges</a>
            @if ($challenge->isOpen() && !$challenge->isUpcoming())
                <a href="#" class="btn btn-primary add-solution-btn" data-bs-toggle="modal" data-bs-target="#addSolutionModal">Add Solution</a>
            @endif        </div>
    </div>

    <div class="challenge-content">
        <div class="image-frame">
            <img src="{{ asset('storage/' . $challenge->image) }}" alt="Challenge Image" class="img-fluid challenge-image" />
        </div>
        <div class="challenge-details">
            <p><strong>Description:</strong> {{ $challenge->description }}</p>
            <p><strong>Start Date:</strong> {{ $challenge->start_date }}</p>
            <p><strong>End Date:</strong> {{ $challenge->end_date }}</p>
            <p><strong>Time Left:</strong> <span id="time-left"></span></p> <!-- Updated for real-time -->
            <p><strong>Reward Points:</strong> {{ $challenge->reward_points }}</p>
        </div>
    </div>
 


    <div class="solution-list">
        <h3>Solutions</h3>
        @if ($isClosed && $winningSolutions->count())
<div class="winner-container">
    <div class="podium">
    
        @foreach ($winningSolutions as $solution)
            <div class="podium-position">
                <i class="fas fa-trophy trophy-icon"></i>
                <div class="winner-info">
                    <strong class="winner-name">🎉{{ $solution->user->name }}🎉</strong>
                    <p class="winner-title">{{ $solution->title }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="alert alert-success">
        Congratulations to the winner(s) :
        @foreach ($winningSolutions as $solution)
            <strong>{{ $solution->title }}</strong> by <strong>{{ $solution->user->name }}</strong>@if (!$loop->last), @endif
        @endforeach
    </div>
</div>
@endif





        <div class="solution-filter-container">
        <div class="solution-filter">
            <label for="solutionSort">Sort Solutions By:</label>
            <select id="solutionSort" onchange="sortSolutions()">
                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="votes" {{ request('sort') === 'votes' ? 'selected' : '' }}>Votes</option>
            </select>
        </div>
    </div>

        @foreach($solutions as $solution)
        <div class="solution-item">
    <div class="solution-header">
    <div class="user-info">
            <img src="/assets/img/team/profile-picture-5.jpg" alt="User Image" class="user-image">
            <strong>{{ $solution->user->name }}</strong>
        </div>
        <span class="solution-date">{{ $solution->created_at->format('d-m-Y H:i') }}</span>
        @if(auth()->id() === $solution->user_id || auth()->user()->role === 'admin')
        <div class="dropdown">
                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    &#x2026;
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item edit-solution" data-solution-id="{{ $solution->id }}" data-bs-toggle="modal" data-bs-target="#editSolutionModal">Edit</a></li>
                    <li><a class="dropdown-item" href="{{ route('solutions.destroy', $solution->id) }}" onclick="event.preventDefault(); document.getElementById('delete-solution-{{ $solution->id }}').submit();">Delete</a></li>
                </ul>
            </div>
            <form id="delete-solution-{{ $solution->id }}" action="{{ route('solutions.destroy', $solution->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>

    <div class="vote-section">
        @if (!$challenge->isClosed())
            <button class="vote-btn {{ $solution->voted ? 'voted' : '' }}" onclick="voteSolution({{ $solution->id }})" data-solution-id="{{ $solution->id }}">
                <i class="fa fa-star"></i>
            </button>
        @else
            <button class="vote-btn" disabled>
                <i class="fa fa-star"></i>
            </button>
        @endif
        <span id="vote-count-{{ $solution->id }}">{{ $solution->votes()->count() }}</span>
    </div>


    <div class="solution-content">
        <h5 id="solution-title-{{ $solution->id }}">{{ $solution->title }}</h5>
        <p id="solution-description-{{ $solution->id }}">{{ $solution->description }}</p>
    </div>
</div>

        @endforeach

        @if($solutions->isEmpty())
            <p>No solutions have been submitted yet.</p>
        @endif
    </div>

<!-- Add Solution Modal -->
<div class="modal fade" id="addSolutionModal" tabindex="-1" aria-labelledby="addSolutionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSolutionModalLabel">Add Solution</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="solutionForm" method="POST" action="{{ route('solutions.store') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="solutionTitle" class="form-label">Solution Title</label>
                        <input type="text" class="form-control" id="solutionTitle" name="title" required minlength="3" maxlength="100">
                        <div class="invalid-feedback">Please enter a valid solution title (3-100 characters).</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <div class="mb-3">
                        <label for="solutionDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="solutionDescription" name="description" rows="3" required minlength="10" maxlength="500"></textarea>
                        <div class="invalid-feedback">Please provide a description (10-500 characters).</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <input type="hidden" name="challenge_id" value="{{ $challenge->id }}">
                    <button type="submit" class="btn btn-primary">Submit Solution</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Solution Modal -->
<div class="modal fade" id="editSolutionModal" tabindex="-1" aria-labelledby="editSolutionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSolutionModalLabel">Edit Solution</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSolutionForm" method="POST" action="" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editSolutionTitle" class="form-label">Solution Title</label>
                        <input type="text" class="form-control" id="editSolutionTitle" name="title" required minlength="3" maxlength="100">
                        <div class="invalid-feedback">Please enter a valid solution title (3-100 characters).</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <div class="mb-3">
                        <label for="editSolutionDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editSolutionDescription" name="description" rows="3" required minlength="10" maxlength="500"></textarea>
                        <div class="invalid-feedback">Please provide a description (10-500 characters).</div>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                    <input type="hidden" id="editSolutionId" name="solution_id">
                    <button type="submit" class="btn btn-primary">Update Solution</button>
                </form>
            </div>
        </div>
    </div>
</div>



    <link rel="stylesheet" href="{{ asset('css/challenge.css') }}">
    <link rel="stylesheet" href="{{ asset('css/solution.css') }}">
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Attach click event listeners to the edit buttons
    document.querySelectorAll('.edit-solution').forEach(button => {
        button.addEventListener('click', function () {
            const solutionId = this.getAttribute('data-solution-id');
            
            // Fetch the solution data for the clicked edit button
            fetch(`/solutions/${solutionId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editSolutionTitle').value = data.title;
                    document.getElementById('editSolutionDescription').value = data.description;
                    document.getElementById('editSolutionId').value = solutionId;

                    // Update form action for submission
                    const form = document.getElementById('editSolutionForm');
                    form.setAttribute('action', `/solutions/${solutionId}`);
                });
        });
    });

    // Handle form submission via AJAX
    const editSolutionForm = document.getElementById('editSolutionForm');
    editSolutionForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        const solutionId = document.getElementById('editSolutionId').value;
        const formData = new FormData(editSolutionForm);

        fetch(`/solutions/${solutionId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editSolutionModal'));
                modal.hide();

                document.querySelector(`#solution-title-${solutionId}`).textContent = document.getElementById('editSolutionTitle').value;
                document.querySelector(`#solution-description-${solutionId}`).textContent = document.getElementById('editSolutionDescription').value;

                showAlert('Solution updated successfully!', 'success');
            }
        })
        .catch(error => {
            console.error('Error updating the solution:', error);
        });
    });
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
// JavaScript to handle form validation on submit
(function () {
    'use strict';
    var forms = document.querySelectorAll('form');

    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
// JavaScript to handle live validation
document.addEventListener('DOMContentLoaded', function () {
    var solutionForm = document.getElementById('solutionForm');
    var editSolutionForm = document.getElementById('editSolutionForm');

    // Live validation for both forms
    [solutionForm, editSolutionForm].forEach(function (form) {
        if (form) {
            var inputs = form.querySelectorAll('input, textarea');

            inputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    if (input.checkValidity()) {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    } else {
                        input.classList.remove('is-valid');
                        input.classList.add('is-invalid');
                    }
                });
            });

            form.addEventListener('submit', function (event) {
                inputs.forEach(function (input) {
                    if (!input.checkValidity()) {
                        event.preventDefault();
                        input.classList.add('is-invalid');
                    }
                });
                form.classList.add('was-validated');
            });
        }
    });
});

    // Get the end date from the PHP variable
    const endDate = new Date("{{ $challenge->end_date }}").getTime();

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
