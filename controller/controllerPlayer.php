<?php

require_once 'model/modelDb.php';
require_once 'model/modelPlayer.php';

$db = dbConnection();

// Identification
function logIn()
{
    global $db;
    $playerManager = new PlayerManager($db); // On charge le model PlayerManager

    $playerName = !empty($_POST['playerName']) ? $_POST['playerName'] : null; // On vérifie l'existence de $playerName
    $password = !empty($_POST['password']) ? $_POST['password'] : null; // On vérifie l'existence de $password
    $getPlayerInfo = $playerManager->getPlayerInfo($playerName); // On récupère les informations liées à $playerName

    if ($getPlayerInfo) {
        $isPasswordCorrect = password_verify($_POST['password'], $getPlayerInfo['password']); // Vérification du mot de passe
        if ($isPasswordCorrect) { // Si le mot de passe correspond, on passe les informations de l'utilisateur à la session, sinon on affiche un message d'erreur
            $_SESSION['id'] = $getPlayerInfo['id'];
            $_SESSION['playerName'] = $getPlayerInfo['playerName'];
            $_SESSION['email'] = $getPlayerInfo['email'];
            $_SESSION['status'] = $getPlayerInfo['status'];
            echo "<div id='home_button'>
                <button>
                    <a href='index.php'>Retour</a>
                </button>
              </div>
              <p>Coucou " . $playerName . " ! Tu es connecté !</p>";
        //header('Location: http://localhost/Games&Friends/index.php');
        } else {
            echo 'Mauvais identifiant ou mot de passe !';
        }
    } else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}
// Déconnexion
function logOut()
{
    session_unset();
    session_destroy();
    header('Location: http://localhost/Games&Friends/index.php'); // On renvoie à la page d'accueil après la déconnexion
}
// Enregistrement
function signIn()
{
    global $db;
    $playerManager = new PlayerManager($db);
    // On vérifie la bonne conformité de tous les champs du formulaire d'enregistrement    
    $playerName = !empty($_POST['playerName']) ? $_POST['playerName'] : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $confirmationPassword = !empty($_POST['confirmationPassword']) ? $_POST['confirmationPassword'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $checkPlayer = $playerManager->getPlayerInfo($playerName); // Vérification de la préexistence de l'utilisateur
    $checkEmail = $playerManager->getPlayerInfo($email); // Vérification de la préexistence de l'email

    if ($playerName === null) {
        echo "Veuillez saisir un nom d'utilisateur valide.";
    } elseif ($password === null) {
        echo "Veuillez saisir un mot de passe.";
    } elseif ($confirmationPassword !== $password || $confirmationPassword === null) {
        echo "Veuillez confirmer votre mot de passe.";
    } elseif ($email === null || !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) { // Vérification du bon format de l'email avec une regex
        echo "Veuillez saisir une adresse e-mail valide.";
    } elseif ($checkPlayer) {
        echo "Pseudonyme déjà utilisé, veuillez en choisir un autre.";
    } elseif ($checkEmail) {
        echo "Adresse mail déjà utilisée, veuillez en choisir un autre.";
    } else {
        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $req = $playerManager->signIn($playerName, $passHash, $email); // Enregistrement du nouvel utilisateur
        echo "<div id='home_button'>
        <button>
            <a href='index.php'>Retour</a>
        </button>
      </div>
      <p>Bienvenue ! Vous vous êtes enregistré sous le pseudonyme " . $playerName . " !</p>";
    }
}
// Affichage du profil
function showPlayerProfil($playerName)
{
    global $db;
    $playerManager = new PlayerManager($db);

    $playerInfo = $playerManager->getPlayerInfo($playerName);
}
// Modification de mot de passe
function updatePlayerPassword($playerName, $password, $newPassword)
{
    global $db;
    $playerManager = new PlayerManager($db);

    $getPlayerInfo = $playerManager->getPlayerInfo($playerName); // On récupère les informations liées à $playerName
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $newPassword = !empty($_POST['newPassword']) ? $_POST['newPassword'] : null;
    $confirmationNewPassword = !empty($_POST['confirmationNewPassword']) ? $_POST['confirmationNewPassword'] : null;

    if ($confirmationNewPassword !== $newPassword || $confirmationNewPassword === null) {
        echo "Veuillez confirmer votre nouveau mot de passe.";
    } elseif ($getPlayerInfo) {
        $isPasswordCorrect = password_verify($_POST['password'], $getPlayerInfo['password']); // Vérification du mot de passe
        if ($isPasswordCorrect) {
        $newPassHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $playerManager->modifyPassword($playerName, $newPassHash);
        } else {
            echo 'Mauvais identifiant ou mot de passe !';
        }
    } else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}
// Modification d'email
function updatePlayerEmail($playerName, $email, $newEmail)
{
    global $db;
    $playerManager = new PlayerManager($db);

    $getPlayerInfo = $playerManager->getPlayerInfo($playerName); // On récupère les informations liées à $playerName
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $newEmail = !empty($_POST['newEmail']) ? $_POST['newEmail'] : null;

    if ($newEmail === null || !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['newEmail'])) {
        echo "Veuillez saisir une adresse e-mail valide.";
    } else {
        $playerManager->modifyEmail($playerName, $newEmail);
    }
}
// Modification de localisation
function updatePlayerLocation()
{
    global $db;
    $playerManager = new PlayerManager($db);

}

// Modification des jeux
function updatePlayerGames()
{
    global $db;
    $playerManager = new PlayerManager($db);

}
