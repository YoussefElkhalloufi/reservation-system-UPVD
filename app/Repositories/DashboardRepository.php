<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function getAdminStats(): array{
        return [
            'utilisateurs' => (int) DB::selectOne("SELECT COUNT(idUtilisateur) as nbUtilisateurs FROM utilisateur")->nbUtilisateurs,
            'salles' => (int) DB::selectOne("SELECT COUNT(codeSalle) as nbSalles FROM SALLE")->nbSalles,
            'reservationsEnAttente' => (int) DB::selectOne("SELECT COUNT(idReservation) as reservations FROM reservation where statut='enAttente'")->reservations,
            'materiels' => (int) DB::selectOne("SELECT COUNT(codeMat) as materiels FROM materiels")->materiels,
        ];
    }

    public function getRecentReservations(): array{
        return DB::select("CALL getRecentReservations()");
    }

}
