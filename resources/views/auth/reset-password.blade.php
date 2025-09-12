@extends('layout.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <h2 class="text-center mb-4 fw-bold" style="color: #1e40af;">Reimposta Password</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nuova Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Conferma Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary-pastel w-100">Reimposta Password</button>
        </form>
    </div>
</div>
@endsection