@extends('layout')

@section('content')

<style>
    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: linear-gradient(135deg, #fff7f1 0%, #ffe3f0 50%, #fff7f1 100%);
        position: relative;
        overflow: hidden;
    }

    .register-container::before {
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

    .register-container::after {
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

    .register-card {
        background: white;
        border-radius: 2rem;
        box-shadow: 0 20px 60px rgba(255, 125, 0, 0.15);
        padding: 3rem 2rem;
        max-width: 500px;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    .register-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .register-header h1 {
        font-family: 'Fredoka One', cursive;
        font-size: 2.2rem;
        color: var(--dunkin-orange);
        margin-bottom: 0.5rem;
    }

    .register-header p {
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
        box-sizing: border-box;
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

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .btn-register {
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

    .btn-register:hover {
        opacity: 0.92;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(255, 90, 121, 0.3);
    }

    .terms-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        margin: 1.5rem 0;
        padding: 1rem;
        background: #f9f9f9;
        border-radius: 0.75rem;
    }

    .terms-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: var(--dunkin-orange);
        cursor: pointer;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .terms-checkbox label {
        color: #666;
        font-size: 0.9rem;
        cursor: pointer;
        margin: 0;
        line-height: 1.5;
    }

    .terms-checkbox a {
        color: var(--dunkin-orange);
        text-decoration: none;
        font-weight: 600;
    }

    .terms-checkbox a:hover {
        color: var(--dunkin-pink);
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

    .password-strength {
        margin-top: 0.5rem;
        font-size: 0.85rem;
    }

    .strength-bar {
        height: 4px;
        background: #e0e0e0;
        border-radius: 2px;
        overflow: hidden;
        margin-top: 0.4rem;
    }

    .strength-fill {
        height: 100%;
        width: 0%;
        transition: width 0.3s, background-color 0.3s;
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
        .register-card {
            padding: 2rem 1.5rem;
        }

        .register-header h1 {
            font-size: 1.8rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <h1>Join Us</h1>
            <p>Create your account to get started</p>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="first_name" class="form-label">First Name</label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        class="form-control @error('first_name') is-invalid @enderror"
                        placeholder="John"
                        value="{{ old('first_name') }}"
                        required
                        autofocus
                    >
                    @error('first_name')
                        <small style="color: var(--dunkin-pink); display: block; margin-top: 0.5rem;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        class="form-control @error('last_name') is-invalid @enderror"
                        placeholder="Doe"
                        value="{{ old('last_name') }}"
                        required
                    >
                    @error('last_name')
                        <small style="color: var(--dunkin-pink); display: block; margin-top: 0.5rem;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

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
                    placeholder="At least 8 characters"
                    required
                    minlength="8"
                >
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <small id="strengthText" style="color: #999;">Password strength: Weak</small>
                </div>
                @error('password')
                    <small style="color: var(--dunkin-pink); display: block; margin-top: 0.5rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Confirm your password"
                    required
                    minlength="8"
                >
                @error('password_confirmation')
                    <small style="color: var(--dunkin-pink); display: block; margin-top: 0.5rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="terms-checkbox">
                <input
                    type="checkbox"
                    id="agree_terms"
                    name="agree_terms"
                    value="1"
                    @checked(old('agree_terms'))
                    required
                >
                <label for="agree_terms">
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" class="btn-register">Create Account</button>
        </form>

        <div class="form-footer">
            <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
        </div>
    </div>
</div>

<script>
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;

            // Length check
            if (value.length >= 8) strength += 20;
            if (value.length >= 12) strength += 20;

            // Lowercase check
            if (/[a-z]/.test(value)) strength += 15;

            // Uppercase check
            if (/[A-Z]/.test(value)) strength += 15;

            // Number check
            if (/\d/.test(value)) strength += 15;

            // Special character check
            if (/[!@#$%^&*]/.test(value)) strength += 15;

            // Update strength bar
            strengthFill.style.width = strength + '%';

            // Update color and text
            if (strength < 40) {
                strengthFill.style.backgroundColor = '#ff6b6b';
                strengthText.textContent = 'Password strength: Weak';
                strengthText.style.color = '#ff6b6b';
            } else if (strength < 70) {
                strengthFill.style.backgroundColor = '#ffa500';
                strengthText.textContent = 'Password strength: Fair';
                strengthText.style.color = '#ffa500';
            } else {
                strengthFill.style.backgroundColor = '#4caf50';
                strengthText.textContent = 'Password strength: Strong';
                strengthText.style.color = '#4caf50';
            }
        });
    }
</script>

@endsection
