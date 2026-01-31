<?php

namespace App\Http\Controllers;

use App\Repositories\DashboardRepository;
use App\Repositories\UtilisateurRepository;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(DashboardRepository $dashboardRepo)
    {
        $user = session('user');

        $stats = $dashboardRepo->getAdminStats();
        $recentReservations = $dashboardRepo->getRecentReservations();

        return view('dashboard.admin.index', compact('user', 'stats', 'recentReservations'));
    }


    public function utilisateurs(UtilisateurRepository $userRepo){
        $user = session('user');

        $users = $userRepo->getUtilisateurs();

        return view('dashboard.admin.utilisateurs', compact('user', 'users'));
    }
}
