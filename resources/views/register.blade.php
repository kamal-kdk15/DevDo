@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 100vh; display: flex; justify-content: center; align-items: center; background-image: url('https://i.pinimg.com/564x/86/13/ae/8613aec518a5e3587ebd6094170c3759.jpg'); background-size: cover; background-position: center;">
    <div class="login-card">
        <div class="card-header">{{ __('Register') }}</div>
        <div class="card-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name" style="font-weight: bold;">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" style="font-weight: bold;">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password" style="font-weight: bold;">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password_confirmation" style="font-weight: bold;">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary" style="background-color: #162D95; border-color: #4a148c;">
                        {{ __('Register') }}
                    </button>
                    @if (Route::has('login'))
                        <a class="btn btn-link" href="{{ route('login') }}" style="color: #162D95;">
                            {{ __('Already registered? Login') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<style>
   .container {
    position: relative;
}

.login-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    width: 100%;
    max-width: 400px;
    margin: 20px;
}

.card-header {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    color: #fff;
}

.card-body {
    color: #fff;
}

.form-control {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #fff !important;
    border-radius: 5px;
    padding: 10px;
    transition: background 0.3s, border 0.3s;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: #fff;
    outline: none; /* Remove outline on focus for better appearance */
}

/* Adjusted to ensure inputs are visible even when not focused */
.form-control:not(:focus) {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: #fff;
}

.btn-primary {
    background-color: #4a148c; /* Darker purple */
    border-color: #4a148c;
    transition: background-color 0.3s, border-color 0.3s;
    color: #fff;
}

.btn-primary:hover {
    background-color: #38006b; /* Darker purple on hover */
    border-color: #38006b;
}

.btn-link {
    color: #4a148c; /* Dark purple */
}

.invalid-feedback {
    color: #ff6f61; /* Light red */
}

.animated-image {
    position: absolute;
    right: 10%;
    top: 10%;
    transform: translateY(-50%);
}

.animated-image img {
    width: 150px; /* Adjust size as needed */
    animation: rotate 5s linear infinite; /* Adjust animation properties as needed */
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
