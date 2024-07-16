<!-- resources/views/edit_timeline_event.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Timeline Event</div>

                <div class="card-body">
                    <form action="{{ route('timeline.update', $event->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" name="company_name" class="form-control" value="{{ $event->company_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="date_from">Date From</label>
                            <input type="date" name="date_from" class="form-control" value="{{ $event->date_from }}" required>
                        </div>

                        <div class="form-group">
                            <label for="date_to">Date To</label>
                            <input type="date" name="date_to" class="form-control" value="{{ $event->date_to }}">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" required>{{ $event->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
