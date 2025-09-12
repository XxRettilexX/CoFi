@extends('layout.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow text-center" style="width: 100%; max-width: 500px; border-radius: 12px;">
        <h2 class="fw-bold mb-3" style="color: #1e40af;">Verifica la tua email</h2>
        <p class="text-secondary mb-3">Prima di procedere, controlla la tua email per il link di verifica.</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary-pastel">Rinvia email di verifica</button>
        </form>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none" style="color: #3b82f6;">Logout</button>
        </form>
    </div>
</div>
@endsection