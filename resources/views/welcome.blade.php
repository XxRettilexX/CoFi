@extends('layout.app')

@section('content')
<div class="welcome-container">
    <h1 class="display-4 fw-bold text-primary">CoFi – Gestione Finanziaria Familiare</h1>
    <p class="lead text-secondary mt-3">Organizza le finanze della tua famiglia in modo semplice, sicuro e collaborativo.</p>
    <a href="{{ route('register') }}" class="btn btn-lg" style="background-color: #FFDAC1; color: #333;">Inizia ora</a>
</div>

<div class="row text-center mt-5">
    <div class="col-md-3 mb-3">
        <div class="p-3 rounded" style="background-color: #B5EAD7;">
            <h5>Controllo centralizzato</h5>
            <p>Gestisci tutta la famiglia con un codice unico.</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="p-3 rounded" style="background-color: #A7C7E7;">
            <h5>Collaborazione</h5>
            <p>Invita membri e assegna ruoli personalizzati.</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="p-3 rounded" style="background-color: #FFF5BA;">
            <h5>Sicurezza</h5>
            <p>Dati protetti e GDPR compliant.</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="p-3 rounded" style="background-color: #FFDAC1;">
            <h5>Accesso rapido</h5>
            <p>Login anche tramite codice famigliare.</p>
        </div>
    </div>
</div>
@endsection