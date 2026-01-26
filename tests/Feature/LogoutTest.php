<?php

test('un utilisateur connecté peut se déconnecté', function(){
    session([
        'user' => [
            'idUtilisateur' => 'z90',
            'nomUtilisateur' => 'youssef',
            'prenomUtilisateur' => 'youssef',
            'roleUtilisateur' => 'etudiant',
            'mailUtilisateur' => 'youssef@gmail.com',
        ]
    ]);

    //appelé la route logout
    $response = $this->post('/logout');

    //verifier la redirection
    $response->assertRedirect('/login');

    //verifier que la session utilisateur est supprimé
    $this->assertFalse(session()->has('user'));
});


test('un utilisateur deconnecte ne peut plus acceder au dashboard', function(){
   session([
       'user' => [
           'role' => 'etudiant',
       ]
   ]) ;

   $response = $this->post('/logout');

   $response = $this->get('/dashboard/etudiant');
   $response->assertRedirect('/login');
});

