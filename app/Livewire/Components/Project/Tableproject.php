<?php

namespace App\Livewire\Components\Project;

use App\Livewire\Layout\Developer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Tableproject extends Component
{

   
    public bool $projectCreate = false;

    public string $name = '';
    public string $gitlab_project_id = '';
    public string $gitlab_url = '';
    public string $create_by = '';
    public array $developers = [];
    public int|string|null $manager = null;

    public bool $confirmingAction = false;
    public ?int $projectSelectedId = null;
    public string $actionType = '';

    public function render()
    {
        $projectHeaders = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'gitlab_project_id', 'label' => 'Id Progetto'],
            ['key' => 'gitlab_url', 'label' => 'Url'],
            ['key' => 'manager', 'label' => 'Manager'],
            ['key' => 'developers', 'label' => 'Sviluppatori'],
            ['key' => 'created_by.name', 'label' => 'Creato da'],
            ['key' => 'created_at', 'label' => 'Creato il'],
        ];

        $projects = \App\Models\Project::get();
        
       $developersOption = User::role('developer')
                ->get()
                ->toArray();

        $managers = User::role('manager')
            ->get()
            ->toArray();

        return view('livewire.components.project.tableproject', compact(
            'projects',
            'projectHeaders',
            'developersOption',
            'managers'
        ));
    }
    public function createProject()
    {
        
        logger($this->developers);
        
        $this->validate([
        'name'              => 'required|string|max:255',
        'gitlab_project_id' => [
            'required',
            'int',
            Rule::unique('projects', 'gitlab_project_id')->whereNull('deleted_at'),
        ],        
        'gitlab_url'        => 'required|string',
        'manager'           => 'required|exists:users,id',
        'developers'     => 'nullable|array',
        'developers.*'   => 'required_with:developers|exists:users,id',
        ]);

        $project = \App\Models\Project::create([
            'name'              => $this->name,
            'gitlab_project_id' => $this->gitlab_project_id,
            'gitlab_url'        => $this->gitlab_url,
            'manager_id'        => $this->manager,
            'created_by'        => Auth::user()->id,
        ]);


        $project->developers()->sync(array_filter($this->developers));

        $this->reset([
            'name',
            'gitlab_project_id',
            'gitlab_url',
            'manager',
            'developers',
            'projectCreate',
        ]);

        $this->dispatch('$refresh');
    }


    public function performAction()
    {
        $project = \App\Models\Project::withTrashed()->findOrFail($this->projectSelectedId);

        if ($this->actionType === 'delete') {
            $project->delete();
        }

        if ($this->actionType === 'restore') {
            $project->restore();
        }

        $this->reset(['confirmingAction', 'projectSelectedId', 'actionType']);
    }

    public function confirmAction($id, $type)
    {
        $this->projectSelectedId = $id;
        $this->actionType = $type; 
        $this->confirmingAction = true;
    }
}
