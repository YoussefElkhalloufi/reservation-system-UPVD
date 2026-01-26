<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UtilisateurRepository
{
    /**
     * Retourne un utilisateur (ligne) à partir de l'email, ou null si introuvable.
     */
    public function findByIdUtilisateur(string $idUtilisateur): ?object
    {
        //retourne un seul resultat (objet ou NULL)
        return DB::selectOne(
            "SELECT * FROM utilisateur WHERE idUtilisateur = ? and actif = true LIMIT 1",
            [$idUtilisateur]
        );
    }

}
