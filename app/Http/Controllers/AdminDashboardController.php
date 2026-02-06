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


    public function store(Request $request, UtilisateurRepository $repo)
    {
        // Validation (adapte les champs)
        $data = $request->validate([
            'nom'          => 'required|string|max:60',
            'prenom'       => 'required|string|max:60',
            'email'        => 'required|email|max:120',
            'telephone'    => 'nullable|string|max:20',
            'role'         => 'required|in:admin,enseignant,etudiant',
            'statut'       => 'required|in:actif,inactif',
            'password'     => 'required|string|min:8|confirmed',
        ],
        [ 'password.confirmed' => 'Les mots de passe ne correspondent pas.',]
        );

        // Appel SQL pur via Repository
        $ok = $repo->createUtilisateur($data);

        if (!$ok) {
            return back()->withErrors(['email' => "Impossible de créer l'utilisateur (email déjà utilisé)."])
                ->withInput();
        }

        return back()->with('success', "Utilisateur ajouté avec succès.");
    }
}
