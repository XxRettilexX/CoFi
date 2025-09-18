<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard - {{ auth()->user()->family->name ?? 'Crea la tua famiglia' }}
        </h2>
    </x-slot>

    <div class="container py-6">

        @if(auth()->user()->family)
        {{-- Statistiche principali --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Totale Entrate</h5>
                        <p class="card-text h3">{{ number_format($totalIncome, 2) }} €</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Totale Uscite</h5>
                        <p class="card-text h3">{{ number_format($totalExpenses, 2) }} €</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Bilancio Attuale</h5>
                        <p class="card-text h3">{{ number_format($balance, 2) }} €</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafico entrate/uscite --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Entrate e Uscite Mensili
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ultime transazioni --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Ultime Transazioni
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Descrizione</th>
                                    <th>Tipo</th>
                                    <th>Importo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date->format('d/m/Y') }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ ucfirst($transaction->type) }}</td>
                                    <td>{{ number_format($transaction->amount, 2) }} €</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nessuna transazione registrata</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('monthlyChart').getContext('2d');
            const monthlyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: [{
                            label: 'Entrate',
                            data: @json($monthlyIncome),
                            borderColor: 'rgba(40, 167, 69, 1)',
                            backgroundColor: 'rgba(40, 167, 69, 0.2)',
                            tension: 0.3
                        },
                        {
                            label: 'Uscite',
                            data: @json($monthlyExpenses),
                            borderColor: 'rgba(220, 53, 69, 1)',
                            backgroundColor: 'rgba(220, 53, 69, 0.2)',
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Entrate vs Uscite Mensili'
                        }
                    }
                }
            });
        </script>

        @else
        {{-- Form per creare la famiglia --}}
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" style="background-color: #fdf6f0;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Crea la tua famiglia</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('families.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Famiglia</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Crea Famiglia</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>