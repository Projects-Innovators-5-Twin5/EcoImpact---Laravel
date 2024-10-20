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
    <form action="{{ route('challenges.update', $challenge->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $challenge->title) }}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-6 mb-3">
                    <label for="reward_points" class="form-label">Reward Points</label>
                    <input type="number" name="reward_points" id="reward_points" class="form-control @error('reward_points') is-invalid @enderror" value="{{ old('reward_points', $challenge->reward_points) }}">
                    @error('reward_points')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $challenge->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                <div class="col-lg-6 mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', \Carbon\Carbon::parse($challenge->start_date)->format('Y-m-d\TH:i')) }}">
                    @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-lg-6 mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', \Carbon\Carbon::parse($challenge->end_date)->format('Y-m-d\TH:i')) }}">
                    @error('end_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Challenge Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                @if ($challenge->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $challenge->image) }}" alt="Current Challenge Image" class="img-thumbnail" style="max-width: 150px;">
                    </div>
                @endif
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Challenge</button>
        </div>
    </div>
</form>


@endsection