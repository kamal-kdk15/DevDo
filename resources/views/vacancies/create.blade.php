@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Vacancy</h1>
    <form action="{{ route('vacancies.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" name="type" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="experience">Experience</label>
            <input type="text" name="experience" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="minimum_qualification">Minimum Qualification</label>
            <input type="text" name="minimum_qualification" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Vacancy</button>
    </form>
</div>
@endsection
