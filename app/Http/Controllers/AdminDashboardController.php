<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Utenti non admin
        $users = User::where('active', 1)->get();

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

        return view('dashboard', compact(
            'users',
            'headers',
            'activeUsersCount',
            'projectsCount',
            'reportsSuccess',
            'reportsFailed'
        ));
    }
}
