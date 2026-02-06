<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function getLastIdUser(string $role): int{
        $lastID = DB::selectOne("
        select substring(idUtilisateur, '4') as nvID from utilisateur
        where role=?
        order by nvID + 0 desc
        limit 1;", [$role]);
        if ($lastID){
            return $lastID->nvID+1;
        }
        return 1;
    }

    public function createUtilisateur(array $data): bool
    {
        // Hash du mot de passe (important)
        $hashedPassword = Hash::make($data['password']);


        if($data['role'] == 'etudiant'){
            $newID = $this->getLastIdUser('etudiant');
            $idUser = 'ETU'.$newID;
        }else if ($data['role'] == 'admin'){
            $newID = $this->getLastIdUser('admin');
            $idUser = 'ADM'.$newID;
        }else{
            $newID = $this->getLastIdUser('enseignant');
            $idUser = 'ENS'.$newID;
        }

        try {
            // SQL pur (paramétré => évite SQL injection)
            DB::insert("
                INSERT INTO utilisateur
                (idUtilisateur, nom, prenom, adresseMail, telephone, role, actif, mdp)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ", [
                $idUser,
                $data['nom'],
                $data['prenom'],
                $data['email'],
                $data['telephone'] ?? null,
                $data['role'],
                $data['statut'] == 'actif' ? '1' : '0',
                $hashedPassword,
            ]);

            return true;

        } catch (\Throwable $e) {
            // TODO:Exemple: duplicate key (email unique / id unique)
            return false;
        }
    }
}
