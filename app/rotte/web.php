<?php
use src\controllers\Documentazione;
use src\controllers\Home;
use src\controllers\Utente;


$grugru->router->get('/', [Home::class, 'index']);
$grugru->router->get('/contatti', [Home::class, 'contatti']);
$grugru->router->get('/documentazione', [Home::class, 'documentazione']);
#Non trovata vista
$grugru->router->get('/no', [Home::class,'nonTrovato']);

#Test con database
$grugru->router->get('/utente', [Utente::class, 'index']);
$grugru->router->get('/nuovo/utente', [Utente::class, 'nuovo']);
$grugru->router->post('/nuovo/utente', [Utente::class, 'nuovo']);
$grugru->router->get('/utente/{id:\d+}/{nomeutente}', [Utente::class, 'profilo']);


$grugru->router->post('/contatti', [Home::class, 'contatti']);
$grugru->router->delete('/contatti', [Home::class, 'delete']);


#Documentazione
$grugru->router->get('/documentazione', [Documentazione::class, 'index']);
$grugru->router->get('/errori', [Documentazione::class, 'errori']);
$grugru->router->get('/versioni', [Documentazione::class, 'versioni']);
$grugru->router->get('/contattami', [Documentazione::class, 'contattami']);
$grugru->router->post('/contattami', [Documentazione::class, 'contattami']);
$grugru->router->get('/validazione', [Documentazione::class, 'validazione']);
$grugru->router->get('/configurazione', [Documentazione::class, 'configurazione']);
