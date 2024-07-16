<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Collaboration Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0a192f; /* Dark blue background */
            color: #fff; /* White text */
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #112240; /* Darker blue container background */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            background-color: #1f4068; /* Dark blue card background */
            color: #fff; /* White text */
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .btn-success {
            background-color: #4caf50; /* Green button */
            color: #fff; /* White text */
            border: none;
            padding: 8px 16px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-danger {
            background-color: #f44336; /* Red button */
            color: #fff; /* White text */
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-success:hover, .btn-danger:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 style="text-align: center;">Pending Collaboration Requests</h3>
        @foreach($requests as $request)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $request->idea->project_idea }}</h5>
                <p class="card-text">Requested by: {{ $request->user->name }}</p>
                <p class="card-text">Status: {{ $request->status }}</p>

                <button class="btn btn-success" onclick="respondToRequest('{{ $request->id }}', 'approved')">Accept</button>
                <button class="btn btn-danger" onclick="respondToRequest('{{ $request->id }}', 'rejected')">Reject</button>
            </div>
        </div>
        @endforeach
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function respondToRequest(id, status) {
    $.ajax({
        url: `/profile/requests/${id}/${status}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: status
        },
        success: function(response) {
            alert('Request ' + status + ' successfully!');
            location.reload(); // Reload the page to reflect the changes
        },
        error: function(xhr) {
            console.error(xhr.responseText); // Log the full error response
            if (xhr.status === 422) {
                alert('Validation error: ' + JSON.stringify(xhr.responseJSON.errors));
            } else {
                alert('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
            }
        }
    });
}

</script>

</body>
</html>
