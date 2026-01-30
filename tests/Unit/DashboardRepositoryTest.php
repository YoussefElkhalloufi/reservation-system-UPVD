<?php

use App\Repositories\DashboardRepository;

test('Resultat de l execution de la procedure ', function(){
    //appeler la classe
    $repo = new DashboardRepository();
    $resultat = $repo->getRecentReservations();

    fwrite(STDERR, print_r($resultat, true));
    expect($resultat)->toBeArray();
});
