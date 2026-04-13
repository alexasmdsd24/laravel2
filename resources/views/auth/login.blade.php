@extends('layout')

@section('content')

<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: linear-gradient(135deg, #fff7f1 0%, #ffe3f0 50%, #fff7f1 100%);
        position: relative;
        overflow: hidden;
    }

    .login-container::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: rgba(255, 125, 0, 0.1);
        top: -100px;
        right: -100px;
        filter: blur(10px);
        pointer-events: none;
    }

    .login-container::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255, 60, 125, 0.08);
        bottom: -80px;
        left: -80px;
        filter: blur(10px);
        pointer-events: none;
    }

    .login-card {
        background: white;
        border-radius: 2rem;
        box-shadow: 0 20px 60px rgba(255, 125, 0, 0.15);
        padding: 3rem 2rem;
        max-width: 450px;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .login-header h1 {
        font-family: 'Fredoka One', cursive;
        font-size: 2.2rem;
        color: var(--dunkin-orange);
        margin-bottom: 0.5rem;
    }

    .login-header p {
        color: #666;
        font-size: 1rem;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #391800;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.85rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 0.75rem;
        font-family: 'Rubik', sans-serif;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--dunkin-orange);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(255, 125, 0, 0.1);
    }

    .form-control::placeholder {
        color: #999;
    }

    .btn-login {
        width: 100%;
        padding: 0.9rem 1.5rem;
        background: linear-gradient(45deg, #ff5a79, #ff7d00);
        color: white;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .btn-login:hover {
        opacity: 0.92;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(255, 90, 121, 0.3);
    }

    .form-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e0e0e0;
    }

    .form-footer p {
        color: #666;
        font-size: 0.95rem;
        margin: 0;
    }

    .form-footer a {
        color: var(--dunkin-orange);
        text-decoration: none;
        font-weight: 700;
        transition: color 0.2s;
    }

    .form-footer a:hover {
        color: var(--dunkin-pink);
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 1rem 0;
    }

    .remember-me input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--dunkin-orange);
        cursor: pointer;
    }

    .remember-me label {
        color: #666;
        font-size: 0.95rem;
        cursor: pointer;
        margin: 0;
    }

    .alert {
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: none;
    }

    .alert-danger {
        background: #fee;
        color: #c22;
        border-left: 4px solid var(--dunkin-pink);
    }

    @media (max-width: 576px) {
        .login-card {
            padding: 2rem 1.5rem;
        }

        .login-header h1 {
            font-size: 1.8rem;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to your account</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="your@email.com"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <small style="color: var(--dunkin-pink); display: block; margin-top: 0.5rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Enter your password"
                    required
                >
                @error('password')
                    <small style="color: var(--dunkin-pink); display: block; margin-top: 0.5rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <div class="form-footer">
            <p>Don't have an account? <a href="{{ route('register') }}">Create one now</a></p>
        </div>
    </div>
</div>

@endsection
