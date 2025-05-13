<?php

namespace App\Livewire\Layout;

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
            ->with('roles')
            ->get();

        // Statistiche card
        $activeUsersCount = $users->count();
        $projectsCount = \App\Models\Project::count();
        $reportsSuccess = \App\Models\Report::where('generation_status', 'success')->count();
        $reportsFailed = \App\Models\Report::where('generation_status', 'failed')->count();

        return view('livewire.layout.admin', compact(
            'users',
            'activeUsersCount',
            'projectsCount',
            'reportsSuccess',
            'reportsFailed',
        ));
    }
}
