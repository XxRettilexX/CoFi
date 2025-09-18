@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Membri della Famiglia: {{ $family->name }}</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Data di Iscrizione</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if ($member->id !== Auth::id())
                                    <form action="{{ route('user.family.members.remove', [$family, $member]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Rimuovere questo membro?')">Rimuovi</button>
                                    </form>
                                    @else
                                    <span class="text-muted">Tu</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="{{ route('user.family.index') }}" class="btn btn-secondary">Torna alla Gestione Famiglia</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection