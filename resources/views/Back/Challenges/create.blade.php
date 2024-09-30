@extends('back.layout')
<title>EcoImpact - Challenges</title>

@section('content')
    <div class="py-4">
        <h1 class="h4">Create a New Challenge</h1>
        <p class="mb-0">Fill in the details below to create a new challenge.</p>
    </div>
    <form action="{{ route('challenges.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter challenge title" required minlength="3" maxlength="100">
                        <div class="invalid-feedback">
                            Please provide a valid title (3-100 characters).
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="reward_points" class="form-label">Reward Points</label>
                        <input type="number" name="reward_points" id="reward_points" class="form-control" placeholder="Enter reward points" required min="1" max="1000">
                        <div class="invalid-feedback">
                            Please enter a value between 1 and 1000.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Describe the challenge..." required minlength="10" maxlength="500"></textarea>
                    <div class="invalid-feedback">
                        Please provide a description (10-500 characters).
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
                        <div class="invalid-feedback">
                            Please select a start date.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
                        <div class="invalid-feedback">
                            Please select an end date.
                        </div>
                        <div class="end-date-feedback invalid-feedback" style="display: none;">
                            End date must be after start date.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
    <label for="image" class="form-label">Challenge Image</label>
    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
    
    @if ($errors->has('image'))
        <div class="invalid-feedback" style="display:block;">
            {{ $errors->first('image') }}
        </div>
    @else
        <div class="invalid-feedback">
            Please upload an image (maximum 2MB).
        </div>
    @endif
</div>

                <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Create Challenge</button>
            </div>
        </div>
    </form>

    <script>
    const form = document.querySelector('form');
    const titleInput = document.getElementById('title');
    const rewardPointsInput = document.getElementById('reward_points');
    const descriptionInput = document.getElementById('description');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const imageInput = document.getElementById('image');
    const endDateFeedback = document.querySelector('.end-date-feedback');
    const submitButton = document.getElementById('submit-btn');

    // Live validation for the image input
    imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];

        if (file) {
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            if (file.size > maxSize) {
                imageInput.classList.add('is-invalid');
                imageInput.nextElementSibling.textContent = 'The image size must not exceed 2MB.';
            } else {
                imageInput.classList.remove('is-invalid');
                imageInput.classList.add('is-valid');
                imageInput.nextElementSibling.textContent = 'Image uploaded successfully.';
            }
        } else {
            imageInput.classList.add('is-invalid');
            imageInput.nextElementSibling.textContent = 'Please upload an image.';
        }
        checkFormValidity();
    });

    function validateField(input) {
        if (input.value.trim() === '') {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        } else if (input.checkValidity()) {
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
            titleInput.nextElementSibling.textContent = 'Title must be at least 3 characters.';
            return false;
        } else {
            titleInput.classList.remove('is-invalid');
            titleInput.classList.add('is-valid');
            titleInput.nextElementSibling.textContent = ''; // Clear error message
            return true;
        }
    }

    function validateDescription() {
        if (descriptionInput.value.trim().length < 10) {
            descriptionInput.classList.add('is-invalid');
            descriptionInput.nextElementSibling.textContent = 'Description must be at least 10 characters.';
            return false;
        } else {
            descriptionInput.classList.remove('is-invalid');
            descriptionInput.classList.add('is-valid');
            descriptionInput.nextElementSibling.textContent = ''; // Clear error message
            return true;
        }
    }

    function validateDates() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (startDate && endDate && endDate <= startDate) {
            endDateInput.classList.add('is-invalid');
            endDateFeedback.style.display = 'block'; 
            return false;
        } else {
            endDateInput.classList.remove('is-invalid');
            endDateFeedback.style.display = 'none'; 
            return true;
        }
    }

    function checkFormValidity() {
        // Check if all fields are valid and meet the minimum requirements
        const isFormValid = validateTitle() && 
                            validateDescription() && 
                            titleInput.value.trim() !== '' &&
                            rewardPointsInput.value.trim() !== '' &&
                            descriptionInput.value.trim() !== '' &&
                            startDateInput.value.trim() !== '' &&
                            endDateInput.value.trim() !== '' &&
                            validateDates() &&
                            imageInput.files.length > 0 &&
                            !imageInput.classList.contains('is-invalid');

        // Enable or disable the submit button based on form validity
        submitButton.disabled = !isFormValid;
    }

    // Add event listeners for all input fields
    titleInput.addEventListener('input', () => { validateField(titleInput); checkFormValidity(); });
    rewardPointsInput.addEventListener('input', () => { validateField(rewardPointsInput); checkFormValidity(); });
    descriptionInput.addEventListener('input', () => { validateField(descriptionInput); checkFormValidity(); });
    startDateInput.addEventListener('change', () => { validateField(startDateInput); checkFormValidity(); });
    endDateInput.addEventListener('change', () => { validateField(endDateInput); checkFormValidity(); });

    // Validate form before submission
    form.addEventListener('submit', function(event) {
        validateField(titleInput);
        validateField(rewardPointsInput);
        validateField(descriptionInput);
        validateField(startDateInput);
        validateField(endDateInput);
        validateField(imageInput);

        const isAllValid = validateTitle() && 
                           validateDescription() && 
                           form.checkValidity() && 
                           validateDates() && 
                           imageInput.files.length > 0;

        if (!isAllValid) {
            event.preventDefault(); 
            event.stopPropagation();
            form.classList.add('was-validated'); 

            if (!validateDates()) {
                endDateInput.classList.add('is-invalid');
            }
        } else {
            form.classList.remove('was-validated');
        }
    });
</script>

@endsection
