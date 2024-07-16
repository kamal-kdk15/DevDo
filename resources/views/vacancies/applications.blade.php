@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Applications for {{ $vacancy->title }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($applications->isEmpty())
        <p>No applications received yet.</p>
    @else
        <ul class="list-group">
            @foreach ($applications as $application)
                <li class="list-group-item" style="color:black">
                    <h4>{{ $application->user->name }}</h4>
                    <p>Status: {{ $application->status }}</p>
                    <p>CV: <a href="{{ route('download.cv', ['filename' => basename($application->cv)]) }}">Download CV</a></p>
                    @if (file_exists(storage_path('app/public/' . $application->photo)))
                        <p>Photo: <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $application->photo))) }}" style="width: 300px;" alt="Photo"></p>
                        <!-- <p>Photo: <a href="{{ asset('storage/' . $application->photo) }}" target="_blank">View Photo</a></p> -->
                    @else
                        <p>Photo: No photo available</p>
                    @endif
                    <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="status">Update Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
