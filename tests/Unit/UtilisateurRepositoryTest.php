<?php

use App\Repositories\UtilisateurRepository;

test('findByIdUtilisateur retourne un Null si lutilisateur nexiste pas', function(){
    //appeler la classe
    $repo = new UtilisateurRepository();
    $user = $repo->findByIdUtilisateur('12');

    expect($user)->toBeNull();
});

test('findByUtilisateur retourne un utilisateur si son id existe', function(){
    $repo = new UtilisateurRepository();
    $user = $repo->findByIdUtilisateur('ETU01');

    expect($user)->not->toBeNull()
        ->and($user->nom)->toBe('el khalloufi')
        ->and($user->prenom)->toBe('youssef')
        ->and($user->mdp)->toBe('1234')
        ->and($user->role)->toBe('etudiant');
});
