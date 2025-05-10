<div>
<div class="flex justify-center p-6">
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- CARD 1: Utenti attivi non admin --}}
    <x-mary-card title="Utenti attivi">
        <div class="text-4xl font-bold text-primary">{{ $activeUsersCount }}</div>
        <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">
            Manager e sviluppatori registrati nel sistema
        </div>
    </x-mary-card>

    {{-- CARD 2: Progetti attivi --}}
    <x-mary-card title="Progetti attivi">
        <div class="text-4xl font-bold text-primary">{{ $projectsCount }}</div>
        <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">
            Totale dei progetti configurati
        </div>
    </x-mary-card>

    {{-- CARD 3: Report generati --}}
    <x-mary-card title="Report AI">
        <div class="flex items-center gap-6">
            <divp>
                <div class="text-success text-3xl font-bold">{{ $reportsSuccess }} / {{ $reportsFailed }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Completati / Falliti</div>
            </div>
        </div>
    </x-mary-card>
</div>

<x-mary-table :headers="$headers" :rows="$users" link="/profile"/>
</div>