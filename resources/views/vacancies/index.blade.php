@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vacancies</h1>
    <a href="{{ route('vacancies.create') }}" class="btn btn-primary">Add Vacancy</a>
    <table class="table mt-4" style="color:white">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Location</th>
                <th>Type</th>
                <th>Experience</th>
                <th>Minimum Qualification</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vacancies as $vacancy)
                <tr>
                    <td>{{ $vacancy->title }}</td>
                    <td>{{ $vacancy->description }}</td>
                    <td>{{ $vacancy->location }}</td>
                    <td>{{ $vacancy->type }}</td>
                    <td>{{ $vacancy->experience }}</td>
                    <td>{{ $vacancy->minimum_qualification }}</td>
                    <td>
                        <a href="{{ route('vacancies.show', $vacancy->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('vacancies.edit', $vacancy->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('vacancies.destroy', $vacancy->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
