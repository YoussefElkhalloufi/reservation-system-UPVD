<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UtilisateurRepository
{

    public function findByIdUtilisateur(string $idUtilisateur): ?object
    {
        //retourne un seul resultat (objet ou NULL)
        return DB::selectOne(
            "SELECT * FROM utilisateur WHERE idUtilisateur = ? and actif = true LIMIT 1",
            [$idUtilisateur]
        );
    }

    public function getUtilisateurs(): array{
        return DB::select("
        SELECT idUtilisateur, nom, prenom, adresseMail, role, actif, telephone
            FROM utilisateur
            ORDER BY idUtilisateur");
    }

}
