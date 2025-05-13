<div>
<x-mary-header title="Utenti registrati" separator />
        
        <div class="flex justify-end mb-4">
            <x-mary-button label="Aggiungi utente" @click="$wire.myModal2 = true" class="btn-primary" />
        </div>
        <x-mary-table :headers="$userHeaders" :rows="$users">
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
