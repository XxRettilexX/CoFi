@extends('layout.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <h2 class="text-center mb-4 fw-bold" style="color: #1e40af;">Conferma Password</h2>
        <p class="text-center text-secondary mb-3">Per motivi di sicurezza, inserisci la tua password per continuare.</p>
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary-pastel w-100">Conferma</button>
        </form>
    </div>
</div>
@endsection