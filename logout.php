<?php

require_once 'config.php';

//REVOCA EL ACCESS TOKEN
$google_client->revokeToken();

session_destroy();

//REDIRECCIONA A index.php
header('location:index.php');

?>