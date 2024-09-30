@extends('back.layout')
<title>EcoImpact - Challenges</title>

@section('content')
    <div class="py-4">
        <h1 class="h4">Edit Challenge</h1>
        <p class="mb-0">Update the details below to modify the challenge.</p>
        <div class="button-group">
            <a href="{{ route('challenges.index') }}" class="btn btn-secondary back-btn">Back to Challenges</a>
        </div>
    </div>

    <form action="{{ route('challenges.update', $challenge->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $challenge->title }}" required minlength="3" maxlength="100">
                        <div class="invalid-feedback">
                            Please provide a valid title (3-100 characters).
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
    <label for="reward_points" class="form-label">Reward Points</label>
    <input type="number" name="reward_points" id="reward_points" class="form-control" value="{{ $challenge->reward_points }}" required min="1" max="1000">
    <div class="invalid-feedback">
        Please enter a value between 1 and 1000.
    </div>
</div>

                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required minlength="10" maxlength="500">{{ $challenge->description }}</textarea>
                    <div class="invalid-feedback">
                        Please provide a description (10-500 characters).
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="{{ \Carbon\Carbon::parse($challenge->start_date)->format('Y-m-d\TH:i') }}" required>
                        <div class="invalid-feedback">
                            Please select a start date.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="{{ \Carbon\Carbon::parse($challenge->end_date)->format('Y-m-d\TH:i') }}" required>
                        <div class="invalid-feedback">
                            Please select an end date.
                        </div>
                        <div class="end-date-feedback invalid-feedback">
                            End date must be after start date.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Challenge Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    @if ($challenge->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $challenge->image) }}" alt="Current Challenge Image" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Update Challenge</button>
            </div>
        </div>
    </form>

    <script>
    // Live validation
    const form = document.querySelector('form');
    const titleInput = document.getElementById('title');
    const rewardPointsInput = document.getElementById('reward_points');
    const descriptionInput = document.getElementById('description');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const imageInput = document.getElementById('image');
    const endDateFeedback = document.querySelector('.end-date-feedback');
    const submitButton = document.getElementById('submit-btn');

    function validateField(input) {
        if (input.checkValidity()) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
    }

    function validateTitle() {
        if (titleInput.value.trim().length < 3) {
            titleInput.classList.add('is-invalid');
            return false;
        }
        return true;
    }

    function validateDescription() {
        if (descriptionInput.value.trim().length < 10) {
            descriptionInput.classList.add('is-invalid');
            return false;
        }
        return true;
    }

    function validateDates() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (startDate && endDate && endDate < startDate) {
            endDateInput.classList.add('is-invalid');
            endDateFeedback.style.display = 'block'; // Show custom feedback
            return false;
        } else {
            endDateInput.classList.remove('is-invalid');
            endDateFeedback.style.display = 'none'; // Hide custom feedback
            return true;
        }
    }

    function validateRewardPoints() {
        const rewardPointsValue = parseInt(rewardPointsInput.value, 10);
        if (rewardPointsValue < 1 || rewardPointsValue > 1000) {
            rewardPointsInput.classList.add('is-invalid');
            rewardPointsInput.nextElementSibling.textContent = 'Please enter a value between 1 and 1000.';
            return false;
        } else {
            rewardPointsInput.classList.remove('is-invalid');
            rewardPointsInput.classList.add('is-valid');
            rewardPointsInput.nextElementSibling.textContent = ''; // Clear error message
            return true;
        }
    }

    function validateImage() {
        const file = imageInput.files[0]; // Get the selected file
        if (file) {
            const maxSizeInBytes = 2 * 1024 * 1024; // 2 MB
            if (file.size > maxSizeInBytes) {
                imageInput.classList.add('is-invalid');
                imageInput.nextElementSibling.textContent = 'Image size must be less than 2MB.';
                return false;
            } else {
                imageInput.classList.remove('is-invalid');
                imageInput.classList.add('is-valid');
                imageInput.nextElementSibling.textContent = ''; // Clear error message
                return true;
            }
        }
        return true; // If no file is selected, assume valid for now
    }

    function checkFormValidity() {
        const isFormValid = validateTitle() && 
                            validateDescription() && 
                            validateRewardPoints() && 
                            validateImage() && 
                            form.checkValidity() && 
                            validateDates();
        submitButton.disabled = !isFormValid; // Enable or disable the submit button
    }

    titleInput.addEventListener('input', () => { validateField(titleInput); checkFormValidity(); });
    rewardPointsInput.addEventListener('input', () => { validateField(rewardPointsInput); checkFormValidity(); });
    descriptionInput.addEventListener('input', () => { validateField(descriptionInput); checkFormValidity(); });
    startDateInput.addEventListener('change', () => { validateField(startDateInput); checkFormValidity(); });
    endDateInput.addEventListener('change', () => { validateField(endDateInput); checkFormValidity(); });
    imageInput.addEventListener('change', () => { validateImage(); checkFormValidity(); }); // Validate image on change

    form.addEventListener('submit', function(event) {
        validateField(titleInput);
        validateField(rewardPointsInput);
        validateField(descriptionInput);
        validateField(startDateInput);
        validateField(endDateInput);
        
        const isAllValid = validateTitle() && 
                           validateDescription() && 
                           validateRewardPoints() && 
                           validateImage() && // Check image validation
                           form.checkValidity() && 
                           validateDates();

        if (!isAllValid) {
            event.preventDefault(); // Prevent form submission
            event.stopPropagation(); // Stop propagation
            form.classList.add('was-validated'); // Show validation feedback
        } else {
            form.classList.remove('was-validated');
        }
    });
</script>
@endsection
