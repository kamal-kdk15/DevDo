@extends('adminlte::page')

@section('title', 'Admin - Vacancies')

@section('content_header')
    <h1>Vacancies</h1>
@stop

@section('content')
    <div class="row">
        @forelse ($vacancies as $vacancy)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">{{ $vacancy->title }}</h5>
                                <p class="card-text">Location: {{ $vacancy->location }}</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <!-- <p class="mb-0">ID: {{ $vacancy->id }}</p> -->
                                <p class="mb-0">Created by: {{ $vacancy->user->name }}</p>
                                <a href="{{ route('admin.vacancies.show', $vacancy) }}" class="btn btn-info">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-info">
                    No vacancies found.
                </div>
            </div>
        @endforelse
    </div>
@stop

@section('css')
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            box-shadow: 0 0 11px rgba(33,33,33,.2);
        }
        .card-body {
            padding: 1.25rem;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .card-text {
            color: #666;
            margin-bottom: 0.5rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    </style>
@stop
