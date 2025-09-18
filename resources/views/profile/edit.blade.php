<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profilo Utente
        </h2>
    </x-slot>

    <div class="container py-6">
        <div class="row g-4">

            {{-- Aggiorna informazioni profilo --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="background-color: #fdf6f0;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Informazioni Account</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Aggiorna password --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="background-color: #f0f7fd;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Cambia Password</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Elimina account --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="background-color: #fff0f0;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 text-danger">Elimina Account</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>