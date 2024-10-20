@extends('back.layout')
<title>EcoImpact - Challenges</title>

@section('content')
<div class="py-4">
    <h1 class="h4">Create a New Challenge</h1>
    <p class="mb-0">Fill in the details below to create a new challenge.</p>
</div>
<form action="{{ route('challenges.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="row">
                <!-- Title Field -->
                <div class="col-lg-6 mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                           placeholder="Enter challenge title" value="{{ old('title') }}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Reward Points Field -->
                <div class="col-lg-6 mb-3">
                    <label for="reward_points" class="form-label">Reward Points</label>
                    <input type="number" name="reward_points" id="reward_points" class="form-control @error('reward_points') is-invalid @enderror"
                           placeholder="Enter reward points" value="{{ old('reward_points') }}">
                    @error('reward_points')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Description Field -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                          rows="4" placeholder="Describe the challenge...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                <!-- Start Date Field -->
                <div class="col-lg-6 mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror"
                           value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- End Date Field -->
                <div class="col-lg-6 mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror"
                           value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Image Field -->
            <div class="mb-3">
                <label for="image" class="form-label">Challenge Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Create Challenge</button>
        </div>
    </div>
</form>
@endsection