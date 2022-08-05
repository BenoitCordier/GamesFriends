<?php

require_once 'model/modelDb.php';
$db = dbConnection();

// Temporaire
function goHome() {
    header('Location: http://localhost/Games&Friends/view/homeView.php');
}