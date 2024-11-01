<div class="challenge-container">

    <div class="row challenge-content">

        @foreach ($challenges as $challenge)
            <div class="col-lg-4 mb-4">
                <div class="card shadow challenge-card">
                    <div class="image-framecard">
                    <img src="{{ asset('storage/' . $challenge['image']) }}" alt="Challenge Image" class="img-fluid challenge-image" />
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">{{ $challenge['title'] }}</h5>
                    <p class="card-text">{{ Str::limit($challenge['description'], 20) }}</p>

                        <!-- Status Indicator -->
                        <div class="mb-2">
                        @if (Carbon\Carbon::now()->lt($challenge['start_date']))
                        <span class="badge bg-warning">Upcoming</span>
                            @elseif (Carbon\Carbon::now()->lt($challenge['end_date']))
                                <span class="badge bg-success">Open</span>
                            @else
                                <span class="badge bg-danger">Closed</span>



                            @endif
                        </div>


                        <a href="{{ route('challenges.showfront', $challenge['id']) }}" class="btn btn-primary">View Challenge</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<link rel="stylesheet" href="{{ asset('css/challenge.css') }}">

