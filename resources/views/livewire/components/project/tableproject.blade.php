<div>

    <x-mary-header title="Progetti registrati" separator />
        
        <div class="flex justify-end mb-4">
            <x-mary-button label="Aggiungi Progetto" @click="$wire.projectCreate = true" class="btn-primary" />
        </div>

    <x-mary-table :headers="$projectHeaders" :rows="$projects">  
     {{-- Colonna sviluppatori --}}
    @scope('cell_developers', $project)
            @foreach ($project->developers as $dev)
                <x-mary-badge :value="$dev->name" class="badge-soft" />    
            @endforeach
    @endscope

    @scope('cell_manager', $project)
        <x-mary-badge :value="$project->manager->name" class="badge-soft" />    
    @endscope


    {{-- Colonna azioni --}}
    @scope('actions', $project)
        <div class="flex items-center gap-2">
            @if ($project->trashed())
                <x-mary-button 
                    icon="o-check"
                    class="btn-success tooltip"
                    data-tip="Ripristina progetto"
                    wire:click="confirmAction({{ $project->id }}, 'restore')"
                />
            @else
                <x-mary-button 
                    icon="o-trash"
                    class="btn-error tooltip"
                    data-tip="Elimina progetto"
                    wire:click="confirmAction({{ $project->id }}, 'delete')"
                />
            @endif
        </div>
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
    
    
    <x-mary-modal wire:model="projectCreate" title="Nuovo utente" subtitle="Compila i dati per creare un progetto">
        <x-mary-form wire:submit.prevent="createProject">
            <x-mary-input label="Nome" wire:model.defer="name" />
            <x-mary-input label="GitLab Project ID" wire:model.defer="gitlab_project_id" />
            <x-mary-input label="GitLab URL" wire:model.defer="gitlab_url" />

            <x-mary-select
                label="Manager"
                placeholder="Seleziona un manager"
                :options="\App\Models\User::role('manager')->get()->map(fn($m) => ['name' => $m->name, 'value' => $m->id])->toArray()"
                option-label="name"
                option-value="value"
                wire:model.defer="manager"
            />

            <x-mary-choices
                label="Developer"
                multiple
                wire:model.deref="developers"
                :options="$developersOption"
                placeholder="Seleziona sviluppatori"
            />

    
            <x-slot:actions>
                <x-mary-button label="Annulla" @click="$wire.projectCreate = false" />
                <x-mary-button label="Conferma" class="btn-primary" type="submit" />
            </x-slot:actions>
        </x-mary-form>

    </x-mary-modal>


</div>
