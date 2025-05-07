<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $activeUsersCount = User::whereDoesntHave('roles', fn ($q) => $q->where('name', 'admin'))->count();
        $projectsCount = Project::count();
        $reportsSuccess = Report::where('generation_status', 'success')->count();
        $reportsFailed = Report::where('generation_status', 'failed')->count();

        return view('dashboard', compact(
            'activeUsersCount',
            'projectsCount',
            'reportsSuccess',
            'reportsFailed'
        ));
    }

}
