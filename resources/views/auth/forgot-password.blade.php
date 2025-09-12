@extends('layout.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <h2 class="text-center mb-4 fw-bold" style="color: #1e40af;">Recupera Password</h2>
        <p class="text-center text-secondary mb-3">Inserisci la tua email e riceverai un link per reimpostare la password.</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary-pastel w-100">Invia link di reset</button>
        </form>
    </div>
</div>
@endsection