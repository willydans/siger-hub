<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Activity Log Export</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Activity Log</h2>
        <p>Exported on {{ date('Y-m-d H:i:s') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>User</th>
                <th>Aktivitas</th>
                <th>IP Address</th>
                <th>Device</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $activity->user ? $activity->user->name : 'Guest' }}</td>
                <td>{{ $activity->type }} {{ $activity->description ? '- ' . $activity->description : '' }}</td>
                <td>{{ $activity->ip_address ?? '-' }}</td>
                <td>{{ $activity->user_agent ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>