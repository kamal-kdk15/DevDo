<!-- resources/views/edit_achievement.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Achievement</h3>
        <form action="{{ route('achievements.update', $achievement->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $achievement->achievement_title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" required>{{ $achievement->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-control" value="{{ $achievement->date }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Achievement</button>
        </form>
    </div>
@endsection
