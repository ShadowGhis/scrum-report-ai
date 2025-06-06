<?php

namespace App\Livewire\Components\Users;

use App\Models\User;
use Livewire\Component;

class TableUsers extends Component
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
            ->with('roles')
            ->get();
        
        $userHeaders = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'roles.0.name', 'label' => 'Ruolo'],
        ];

      
        return view('livewire.components.users.tableusers', compact(
            'users',
            'userHeaders',
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
