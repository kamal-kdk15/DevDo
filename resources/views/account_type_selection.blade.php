@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Select Your Account Type</div>
                <div class="card-body">
                    
                    <form method="POST" action="{{ route('account_type.selection') }}">
                        @csrf
                        <div class="form-group">
                            <label for="account_type">Account Type</label>
                            <select id="account_type" name="account_type" class="form-control" required>
                                @foreach($accountTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
