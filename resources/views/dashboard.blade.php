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
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Totale Entrate</h5>
                        <p class="card-text h3">{{ number_format($totalIncome, 2) }} €</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Totale Uscite</h5>
                        <p class="card-text h3">{{ number_format($totalExpenses, 2) }} €</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Bilancio Attuale</h5>
                        <p class="card-text h3">{{ number_format($balance, 2) }} €</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Membri Attivi</h5>
                        <p class="card-text h3">{{ $membersCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafico entrate/uscite --}}
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Entrate e Uscite Mensili
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Distribuzione Spese per Categoria
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistiche avanzate --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Spese per Membro (Ultimi 30 giorni)
                    </div>
                    <div class="card-body">
                        <canvas id="memberExpenseChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Andamento Cumulativo Annuale
                    </div>
                    <div class="card-body">
                        <canvas id="cumulativeChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ultime transazioni --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Ultime Transazioni</span>
                        <a href="{{ route('user.transactions.index') }}" class="btn btn-sm btn-outline-primary">Vedi tutte</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Data</th>
                                        <th>Descrizione</th>
                                        <th>Categoria</th>
                                        <th>Membro</th>
                                        <th>Tipo</th>
                                        <th class="text-end">Importo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->date->format('d/m/Y') }}</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $transaction->category ?? 'Nessuna' }}</span>
                                        </td>
                                        <td>{{ $transaction->user->name }}</td>
                                        <td>
                                            <span class="badge {{ $transaction->type === 'income' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $transaction->type === 'income' ? 'Entrata' : 'Uscita' }}
                                            </span>
                                        </td>
                                        <td class="text-end {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($transaction->amount, 2) }} €
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Nessuna transazione registrata</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Preparazione dati per i grafici
            const monthlyLabels = @json($monthlyLabels);
            const monthlyIncome = @json($monthlyIncome);
            const monthlyExpenses = @json($monthlyExpenses);

            const categoryLabels = @json($categoryLabels);
            const categoryData = @json($categoryValues);

            const memberLabels = @json($memberLabels);
            const memberData = @json($memberTotals);

            const cumulativeLabels = @json($cumulativeLabels);
            const cumulativeData = @json($cumulativeValues);

            // Grafico mensile entrate/uscite
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            const monthlyChart = new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                            label: 'Entrate',
                            data: monthlyIncome,
                            borderColor: 'rgba(40, 167, 69, 1)',
                            backgroundColor: 'rgba(40, 167, 69, 0.2)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Uscite',
                            data: monthlyExpenses,
                            borderColor: 'rgba(220, 53, 69, 1)',
                            backgroundColor: 'rgba(220, 53, 69, 0.2)',
                            tension: 0.3,
                            fill: true
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
                            text: 'Andamento Mensile'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Importo (€)'
                            }
                        }
                    }
                }
            });

            // Grafico a torta per categorie
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            const categoryChart = new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryData,
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Grafico a barre per spese per membro
            const memberCtx = document.getElementById('memberExpenseChart').getContext('2d');
            const memberChart = new Chart(memberCtx, {
                type: 'bar',
                data: {
                    labels: memberLabels,
                    datasets: [{
                        label: 'Spese per Membro',
                        data: memberData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Spese per Membro'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Importo (€)'
                            }
                        }
                    }
                }
            });

            // Grafico cumulativo annuale
            const cumulativeCtx = document.getElementById('cumulativeChart').getContext('2d');
            const cumulativeChart = new Chart(cumulativeCtx, {
                type: 'line',
                data: {
                    labels: cumulativeLabels,
                    datasets: [{
                        label: 'Bilancio Cumulativo',
                        data: cumulativeData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Andamento Cumulativo Annuale'
                        }
                    },
                    scales: {
                        y: {
                            title: {
                                display: true,
                                text: 'Bilancio (€)'
                            }
                        }
                    }
                }
            });
        </script>

        @else
        {{-- Form per creare la famiglia --}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #fdf6f0 0%, #f8f9fa 100%);">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-center">Benvenuto in CoFi!</h5>
                        <p class="text-muted text-center mb-0">Inizia creando la tua famiglia o unendoti a una esistente</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100 border-0">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-home fa-3x text-primary"></i>
                                        </div>
                                        <h5>Crea una Nuova Famiglia</h5>
                                        <p class="text-muted">Crea una nuova famiglia e invita altri membri</p>
                                        <form action="{{ route('user.family.store') }}" method="POST">
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
                            <div class="col-md-6">
                                <div class="card h-100 border-0">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-users fa-3x text-success"></i>
                                        </div>
                                        <h5>Unisciti a una Famiglia</h5>
                                        <p class="text-muted">Hai già un codice famiglia? Unisciti ora!</p>
                                        <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#joinFamilyModal">
                                            Unisciti a una Famiglia
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal per unirsi a famiglia -->
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
                                <input type="text" class="form-control" id="code" name="code" required placeholder="Inserisci il codice della famiglia">
                                <div class="form-text">Chiedi al capofamiglia il codice di invito</div>
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
        @endif

    </div>
</x-app-layout>