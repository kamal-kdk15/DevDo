@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Details of User {{ $user->name }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ $user->role }}</td>
                            </tr>
                            <!-- Add more fields as necessary -->
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default">Back to Users List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
