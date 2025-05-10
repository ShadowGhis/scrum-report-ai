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
                    <div>
                        <div class="text-success text-3xl font-bold">{{ $reportsSuccess }} / {{ $reportsFailed }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Completati / Falliti</div>
                    </div>
                </div>
            </x-mary-card>
        </div>
    </div>

    <div class="mt-10">
        <div class="flex justify-end mb-4">
            <x-mary-button label="Aggiungi utente" @click="$wire.myModal2 = true" class="btn-primary" />
        </div>
        
        <x-mary-header title="Utenti registrati" separator />
        
    <x-mary-table :headers="$headers" :rows="$users">
         @scope('actions', $user)
             @if ($user->trashed())
              <x-mary-button 
                icon="o-check"
                class="btn-success tooltip"
                data-tip="Riattiva utente"
                wire:click="confirmAction({{ $user->id }}, 'restore')"
            />
        @else
            <x-mary-button 
                icon="o-trash"
                class="btn-error tooltip"
                data-tip="Disattiva utente"
                wire:click="confirmAction({{ $user->id }}, 'delete')"
            />
        @endif
    @endscope
    </x-mary-table>

    <x-mary-modal wire:model="confirmingAction" title="Conferma azione">
        <x-slot name="subtitle">
        {!! $actionType === 'delete'
            ? 'Sei sicuro di voler disattivare questo utente?'
            : 'Vuoi davvero riattivare questo utente?' !!}
    </x-slot>

    <x-slot:actions>
        <x-mary-button label="Annulla" @click="$wire.confirmingAction = false" />
        <x-mary-button 
            label="Conferma" 
            class="{{ $actionType === 'delete' ? 'btn-error' : 'btn-success' }}" 
            wire:click="performAction" 
        />
    </x-slot:actions>
    </x-mary-modal>


        <x-mary-modal wire:model="myModal2" title="Nuovo utente" subtitle="Compila i dati per creare un utente">
        <x-mary-form wire:submit.prevent="createUser">
            <x-mary-input label="Nome" wire:model.defer="name" icon="o-user" placeholder="Mario Rossi" />
            <x-mary-input label="Email" wire:model.defer="email" icon="o-envelope" placeholder="mario@example.com" />
            <x-mary-password label="Password" wire:model.defer="password" right />
            <x-mary-select
                label="Ruolo"
                placeholder="Scegli un ruolo"
                :options="[
                    ['name' => 'Admin', 'value' => 'admin'],
                    ['name' => 'Manager', 'value' => 'manager'],
                    ['name' => 'Developer', 'value' => 'developer'],
                ]"
                option-label="name"
                option-value="value"
                wire:model.defer="role"
            />

            <x-slot:actions>
                <x-mary-button label="Annulla" @click="$wire.myModal2 = false" />
                <x-mary-button label="Conferma" class="btn-primary" type="submit" />
            </x-slot:actions>
    </x-mary-form>
</x-mary-modal>

    </div>

</div>
