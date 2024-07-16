<!-- resources/views/edit_design_philosophy.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Design Philosophy</h3>
        
        <form action="{{ route('designer-philosophy.update', $designPhilosophy->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="design_philosophy">Design Philosophy</label>
                <textarea name="design_philosophy" class="form-control" required>{{ $designPhilosophy->design_philosophy }}</textarea>
            </div>

            <div class="form-group">
                <label for="adaptability">Adaptability</label>
                <textarea name="adaptability" class="form-control" required>{{ $designPhilosophy->adaptability }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Design Philosophy</button>
        </form>
    </div>
@endsection
