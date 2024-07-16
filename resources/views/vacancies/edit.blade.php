@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Vacancy</h1>
    <form action="{{ route('vacancies.update', $vacancy->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $vacancy->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $vacancy->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="{{ $vacancy->location }}" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" name="type" class="form-control" value="{{ $vacancy->type }}" required>
        </div>
        <div class="form-group">
            <label for="experience">Experience</label>
            <input type="text" name="experience" class="form-control" value="{{ $vacancy->experience }}" required>
        </div>
        <div class="form-group">
            <label for="minimum_qualification">Minimum Qualification</label>
            <input type="text" name="minimum_qualification" class="form-control" value="{{ $vacancy->minimum_qualification }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Vacancy</button>
    </form>
</div>
@endsection
