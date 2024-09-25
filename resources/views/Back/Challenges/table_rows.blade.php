<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/challenge.css') }}">

@foreach ($challenges as $challenge)
    <tr>
        <td>{{ $challenge->title }}</td>
        <td>{{ Str::limit($challenge->description, 20) }}</td>
        <td>{{ $challenge->start_date }}</td>
        <td>{{ $challenge->end_date }}</td>
        <td>{{ $challenge->reward_points }}</td>
        <td>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $challenge->id }}" onclick="populateViewModal('{{ $challenge->id }}', '{{ $challenge->title }}', '{{ $challenge->description }}', '{{ $challenge->start_date }}', '{{ $challenge->end_date }}', {{ $challenge->reward_points }})">
                <i class="fas fa-eye"></i> 
            </button>
            <a href="{{ route('challenges.edit', $challenge->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> 
            </a>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $challenge->id }}">
                <i class="fas fa-trash"></i> 
            </button>
            <a href="{{ route('challenges.show', $challenge->id) }}" class="btn btn-success">
                <i class="fas fa-list"></i> 
            </a>
            <div class="modal fade" id="deleteModal{{ $challenge->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $challenge->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $challenge->id }}">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete the challenge "<strong>{{ $challenge->title }}</strong>"?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('challenges.destroy', $challenge->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Modal -->
            <div class="modal fade" id="viewModal{{ $challenge->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $challenge->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewModalLabel{{ $challenge->id }}">Challenge Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <div class="image-framecard">
        <img src="{{ asset('storage/' . $challenge->image) }}" alt="Challenge Image" class="img-fluid challenge-image" />
    </div>                            <strong>Title:</strong> <span id="viewTitle{{ $challenge->id }}">{{ $challenge->title }}</span><br>
                            <strong>Description:</strong> <span id="viewDescription{{ $challenge->id }}">{{ $challenge->description }}</span><br>
                            <strong>Start Date:</strong> <span id="viewStartDate{{ $challenge->id }}">{{ $challenge->start_date }}</span><br>
                            <strong>End Date:</strong> <span id="viewEndDate{{ $challenge->id }}">{{ $challenge->end_date }}</span><br>
                            <strong>Reward Points:</strong> <span id="viewRewardPoints{{ $challenge->id }}">{{ $challenge->reward_points }}</span><br>
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
