
<head>
    <title>Participants PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/compaign.css') }}">
</head>
<body>
    <h2>List of Participants</h2>
    <h4>Campaign : {{ $campaign->title}} </h4>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date Created</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $participant)
            @php
                $DateCreation = \Carbon\Carbon::parse($participant->created_at);
            @endphp
            <tr>
                <td>{{ $participant->name }}</td>
                <td>{{ $participant->email }}</td>
                <td>{{ $participant->phone }}</td>
                <td>{{ $DateCreation->format('l, F j, Y')}}</td>
                <td>
                    @if ($participant->status === 'pending')
                      <span class="fw-bold status-pending">pending</span>
                    @elseif($participant->status  === 'accepted')
                      <span class="fw-bold status-active">accepted</span>
                    @elseif($participant->status === 'rejected')
                      <span class="fw-bold status-archived">rejected</span>
                    @else
                       <span class="fw-bold status-archived">archived</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

