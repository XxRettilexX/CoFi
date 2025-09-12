@extends('layout.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <h2 class="text-center mb-4 fw-bold" style="color: #1e40af;">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ricordami</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #3b82f6;">Password dimenticata?</a>
            </div>
            <button type="submit" class="btn btn-primary-pastel w-100">Accedi</button>
        </form>
        <p class="mt-3 text-center">Non hai un account? <a href="{{ route('register') }}" style="color: #3b82f6;">Registrati</a></p>
    </div>
</div>
@endsection