<!DOCTYPE html>
<html>
<head>
    <title>Case Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Case Report</h2>

    <p><strong>Case ID:</strong> {{ $case->case_id }}</p>
    <p><strong>Status:</strong> {{ ucfirst($case->status) }}</p>
    <p><strong>Type:</strong> {{ ucfirst($case->type) }}</p>
    <p><strong>Description:</strong> {{ $case->description }}</p>
    <p><strong>Submitted At:</strong> {{ $case->created_at->format('d M Y, H:i') }}</p>

    <h3>Evidence</h3>
    <table>
        <tr>
            <th>#</th>
            <th>File</th>
            <th>Status</th>
            <th>Uploaded At</th>
        </tr>
        @foreach($case->evidences as $key => $evidence)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $evidence->file_path }}</td>
                <td>{{ ucfirst($evidence->status) }}</td>
                <td>{{ $evidence->created_at->format('d M Y, H:i') }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
