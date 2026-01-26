<?php

test('redirige vers login si utilisateur non connecté', function(){
    $response = $this->get('/dashboard/admin');
    $response->assertRedirect('/login');
});


test('refuse lacces admin à etudiant', function(){
   session([
       'user'=>[
           'idUtilisateur' => 'z90',
           'nomUtilisateur' => 'youssef',
           'prenomUtilisateur' => 'youssef',
           'roleUtilisateur' => 'etudiant',
           'mailUtilisateur' => 'youssef@gmail.com',
       ]
   ]);
   $response = $this->get('/dashboard/admin');
   $response->assertStatus(403);
});


test('autorise lacces admin à un administrateur', function(){
   session([
       'user'=>[
           'idUtilisateur' => 'z90',
           'nomUtilisateur' => 'youssef',
           'prenomUtilisateur' => 'youssef',
           'roleUtilisateur' => 'admin',
           'mailUtilisateur' => 'admin@gmail.com'
       ]
   ]);
   $response = $this->get('/dashboard/admin');
   $response->assertStatus(200);
});
