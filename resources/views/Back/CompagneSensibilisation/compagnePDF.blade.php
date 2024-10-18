
<head>
    <title>Campaigns PDF</title>
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
</head>
<body>
    <h2>List of Campaigns</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Target audience</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $campaign)
            @php
                $startDate = \Carbon\Carbon::parse($campaign->start_date);
                $endDate = \Carbon\Carbon::parse($campaign->end_date);
            @endphp
            <tr>
                <td>{{ $campaign->title }}</td>
                <td>{{ $startDate->format('l, F j, Y')}}</td>
                <td>{{ $endDate->format('l, F j, Y')}}</td>
                <td>
                    @foreach($campaign->target_audience as $audience)
                     <div>{{$audience}}</div>
                    @endforeach
                </td>
                <td>@if ($campaign->status === 'active')
                      <span class="fw-bold text-success">active</span>
                    @elseif($campaign->status  === 'upcoming')
                      <span class="fw-bold text-info">upcoming</span>
                    @elseif($campaign->status === 'completed')
                      <span class="fw-bold text-warning">completed</span>
                    @else
                       <span class="fw-bold text-danger">archived</span>
                    @endif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

