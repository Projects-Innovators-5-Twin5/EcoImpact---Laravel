<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenges PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Challenges List</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reward Points</th>
            </tr>
        </thead>
        <tbody>
            @foreach($challenges as $challenge)
                <tr>
                    <td>{{ $challenge->title }}</td>
                    <td>{{ $challenge->description }}</td>
                    <td>{{ $challenge->start_date ? $challenge->start_date->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $challenge->end_date ? $challenge->end_date->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $challenge->reward_points }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
