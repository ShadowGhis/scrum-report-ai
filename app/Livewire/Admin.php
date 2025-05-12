<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Admin extends Component
{
    public bool $myModal2 = false;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = '';

    public bool $confirmingAction = false;
    public ?int $selectedUserId = null;
    public string $actionType = '';


    public function render()
    {
        $users = User::withTrashed()
        ->whereHas('roles', fn ($q) => $q->whereIn('name', ['admin', 'manager', 'developer']))
        ->with('roles')
        ->get();
        
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'roles.0.name', 'label' => 'Ruolo'],
        ];

        // Statistiche card
        $activeUsersCount = $users->count();
        $projectsCount = \App\Models\Project::count();
        $reportsSuccess = \App\Models\Report::where('generation_status', 'success')->count();
        $reportsFailed = \App\Models\Report::where('generation_status', 'failed')->count();

        return view('livewire.layout.admin', compact(
            'users',
            'headers',
            'activeUsersCount',
            'projectsCount',
            'reportsSuccess',
            'reportsFailed'
        ));
    }

    public function createUser()
    {
        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,manager,developer',
        ]);

        $user = \App\Models\User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $user->assignRole($this->role);

        // Reset form
        $this->reset(['name', 'email', 'role', 'myModal2']);

        // Reload utenti
        $this->dispatch('$refresh');
    }

    public function performAction()
    {
        $user = \App\Models\User::withTrashed()->findOrFail($this->selectedUserId);

        if ($this->actionType === 'delete') {
            $user->delete();
        }

        if ($this->actionType === 'restore') {
            $user->restore();
        }

        $this->reset(['confirmingAction', 'selectedUserId', 'actionType']);
    }

    public function confirmAction($id, $type)
    {
        $this->selectedUserId = $id;
        $this->actionType = $type; // delete o restore
        $this->confirmingAction = true;
    }

}
