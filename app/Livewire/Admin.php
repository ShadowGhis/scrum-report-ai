<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Admin extends Component
{
    public function render()
    {
        $users = User::role('admin')->get();

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

        return view('livewire.admin', compact(
            'users',
            'headers',
            'activeUsersCount',
            'projectsCount',
            'reportsSuccess',
            'reportsFailed'
        ));
    }
}
