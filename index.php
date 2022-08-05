<?php

// Routeur

session_start();
require 'controller/controllerPlayer.php';

// Routing des requêtes liées à l'indentification
function registrationRouting()
{
    switch ($_GET['action']) {
        case 'logIn':
            logIn();
            break;

        case 'signIn':
            signIn();
            break;

        case 'logOut':
            logOut();
            break;

        default:
            header("HTTP/1.0 404 Not Found");
    }
}
