@extends('layout.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <h2 class="text-center mb-4 fw-bold" style="color: #1e40af;">Registrati</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input id="name" type="text" class="form-control" name="name" required autofocus>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Conferma Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary-pastel w-100">Registrati</button>
        </form>
        <p class="mt-3 text-center">Hai già un account? <a href="{{ route('login') }}" style="color: #3b82f6;">Accedi</a></p>
    </div>
</div>
@endsection