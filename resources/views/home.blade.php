@extends('layout')

@section('content')

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Rubik:wght@400;700&display=swap" rel="stylesheet">

<!-- Hero Section -->
<div class="home-background">
    <div class="hero d-flex flex-column align-items-center justify-content-center text-center">
        <h1 class="hero-title mb-3">Welcome to Dunkin’ Donuts 🍩</h1>
        <p class="hero-subtitle mb-4">Order your favorite coffee & donuts quickly and easily!</p>
        <a href="/menu" class="btn btn-dunkin btn-lg rounded-pill px-5 py-3">Start Ordering</a>
    </div>
</div>

<style>
.home-background {
    min-height: 100vh;
    width: 100%;
    position: relative;
    background: radial-gradient(circle at 20% 20%, rgba(255, 122, 0, 0.25), transparent 55%),
                radial-gradient(circle at 80% 0%, rgba(255, 60, 125, 0.18), transparent 50%),
                linear-gradient(120deg, #fff7f1 0%, #ffe3f0 45%, #fff7f1 100%);
    overflow: hidden;
}

.home-background::after {
    content: '';
    position: absolute;
    inset: 0;
    background: url('https://images.unsplash.com/photo-1517686469429-8bdb88b9f907?auto=format&fit=crop&w=1200&q=60') repeat;
    opacity: 0.05;
    mix-blend-mode: multiply;
    pointer-events: none;
}

.home-background::before {
    content: '';
    position: absolute;
    width: 340px;
    height: 340px;
    border-radius: 50%;
    background: rgba(255, 122, 0, 0.18);
    right: -120px;
    bottom: -80px;
    filter: blur(10px);
    pointer-events: none;
}

/* Full-page Hero with Background */
.hero {
    height: 100vh;
    width: 100%;
    background: linear-gradient(rgba(255,255,255,0.3), rgba(255,255,255,0.3)),
                url('https://images.unsplash.com/photo-1590080871545-d1aa51e5a8d2?auto=format&fit=crop&w=1350&q=80') no-repeat center center;
    background-size: cover;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-family: 'Rubik', sans-serif;
    color: #fff;
    padding: 0 1rem;
}

/* Hero Title */
.hero-title {
    font-family: 'Fredoka One', cursive;
    font-size: 4rem;
    color: #FF5A79; /* Dunkin’ Pink */
}

/* Hero Subtitle */
.hero-subtitle {
    font-size: 2rem;
    color: #FF7D00; /* Dunkin’ Orange */
}

/* Button Styling */
.btn-dunkin {
    font-size: 2rem;
    padding: 1rem 4rem;
    border-radius: 50px;
    background: linear-gradient(45deg, #FF5A79, #FF7D00);
    color: #fff;
    font-weight: bold;
    border: none;
    transition: transform 0.2s, opacity 0.2s;
}

.btn-dunkin:hover {
    opacity: 0.9;
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    .hero-subtitle {
        font-size: 1.25rem;
    }
    .btn-lg {
        font-size: 1.5rem;
        padding: 0.75rem 3rem;
    }
}
</style>

@endsection