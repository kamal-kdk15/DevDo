@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vacancy Details</h1>
    <p><strong>Title:</strong> {{ $vacancy->title }}</p>
    <p><strong>Description:</strong> {{ $vacancy->description }}</p>
    <p><strong>Location:</strong> {{ $vacancy->location }}</p>
    <p><strong>Type:</strong> {{ $vacancy->type }}</p>
    <p><strong>Experience Needed:</strong> {{ $vacancy->experience }}</p>
    <p><strong>Minimum Qualification:</strong> {{ $vacancy->minimum_qualification }}</p>
    @if(Auth::id() != $vacancy->user_id)
    <!-- Apply Button -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyModal">
        Apply
    </button>
    @endif
    <!-- Apply Modal -->
    <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel" style="color: black">Apply for {{ $vacancy->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('vacancies.apply', $vacancy->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body" style="color: black">
        <div class="form-group">
            <label for="cv">Upload CV (PDF, DOC, DOCX)</label>
            <input type="file" class="form-control-file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
        </div>
        <div class="form-group">
            <label for="photo">Upload Photo (JPEG, PNG)</label>
            <input type="file" class="form-control-file" id="photo" name="photo" accept="image/jpeg,image/png" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Apply</button>
    </div>
</form>

            </div>
        </div>
    </div>
</div>

@endsection
