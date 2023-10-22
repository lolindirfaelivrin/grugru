<?php
use src\controllers\Documentazione;
use src\controllers\Home;


$grugru->router->get('/', [Home::class, 'index']);
$grugru->router->get('/contatti', [Home::class, 'contatti']);
$grugru->router->get('/documentazione', [Home::class, 'documentazione']);


$grugru->router->post('/contatti', [Home::class, 'contatti']);
$grugru->router->delete('/contatti', [Home::class, 'delete']);


#Documentazione
$grugru->router->get('/documentazione', [Documentazione::class, 'index']);
$grugru->router->get('/errori', [Documentazione::class, 'errori']);
$grugru->router->get('/versioni', [Documentazione::class, 'versioni']);
$grugru->router->get('/contattami', [Documentazione::class, 'contattami']);
$grugru->router->post('/contattami', [Documentazione::class, 'contattami']);
