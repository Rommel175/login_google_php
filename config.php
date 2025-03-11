<?php

session_start();

require_once 'vendor/autoload.php';

//Inicializa el objeto de la API de google
$google_client = new Google_Client();

//Seteamos el CLIENT ID
$google_client->setClientId('470748868074-vvcr2tb6preml9gsddt4tcvihu51up8s.apps.googleusercontent.com');

//Seteamos el CLIENT SECRET KEY
$google_client->setClientSecret('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');

//SETEAMOS LA URL DE REDIRECCIONAMIENTO
$google_client->setRedirectUri('http://localhost:8000/login.php');

// CONSEGIMOS EL EMAIL Y SU PERFIL.
$google_client->addScope('email');

$google_client->addScope('profile');

?>