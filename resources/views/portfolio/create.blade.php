@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Portfolio Post</h1>
    <form action="{{ route('portfolio.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Project Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Post</button>
    </form>
</div>
@endsection
