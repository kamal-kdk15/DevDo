@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Workspaces</h1>
        <a href="{{ route('workspaces.create') }}" class="btn btn-primary mb-3">Create New Workspace</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <ul class="list-group">
                    @forelse ($workspaces as $workspace)
                        <li class="list-group-item">
                            <a href="{{ route('workspaces.show', $workspace->id) }}">{{ $workspace->name }}</a>
                        </li>
                    @empty
                        <li class="list-group-item">No workspaces found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection

