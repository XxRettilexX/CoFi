@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Gestione Famiglia</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if ($family)
                    <h4>Famiglia: {{ $family->name }}</h4>
                    <p>Codice famiglia: <strong>{{ $family->code }}</strong></p>

                    <div class="mb-3">
                        <a href="{{ route('user.family.members', $family) }}" class="btn btn-info">Gestisci Membri</a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editFamilyModal">Modifica Nome</button>
                        <form action="{{ route('user.family.leave', $family) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler lasciare la famiglia?')">Lascia Famiglia</button>
                        </form>
                    </div>
                    @else
                    <p>Non sei ancora membro di una famiglia.</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.family.create') }}" class="btn btn-primary">Crea una Famiglia</a>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#joinFamilyModal">Unisciti a una Famiglia</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@if (!$family)
<div class="modal fade" id="joinFamilyModal" tabindex="-1" aria-labelledby="joinFamilyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="joinFamilyModalLabel">Unisciti a una Famiglia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.family.join') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Codice Famiglia</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-primary">Unisciti</button>
                </div>
            </form>
        </div>
    </div>
</div>
@else
<div class="modal fade" id="editFamilyModal" tabindex="-1" aria-labelledby="editFamilyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFamilyModalLabel">Modifica Nome Famiglia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.family.update', $family) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Famiglia</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $family->name }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-primary">Salva Modifiche</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection