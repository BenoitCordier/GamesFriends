<!DOCTYPE html>

<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Billet Simple pour l'Alaska">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- <meta property="og:url" content="http://jeanforteroche.bcordier.fr/index.php" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Billet Simple pour l'Alaska" />
    <meta property="og:description" content="Billet Simple pour l'Alaska - Le nouveau livre de Jean Forteroche" />
-->
	<title><?= $title ?>
	</title>
	<!-- <link href="public/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="(max-width: 768px)" href="public/css/mobres.css">
    <link rel="stylesheet" type="text/css" media="(min-width: 769px) and (max-width: 1024px)"
        href="public/css/lowres.css">
    <link rel="stylesheet" type="text/css" media="(min-width: 1025px) and (max-width: 1200px)"
        href="public/css/medres.css">
    <script src="https://cdn.tiny.cloud/1/g5suvpkd4ia0orxi5hyg7ykb4lhbo8ekfij53v9ejdf331m5/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea#tiny',
            menubar: '',
            toolbar: 'undo redo | fontselect fontsizeselect forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | blockquote | removeformat',

        });
    </script> -->
</head>
<!-- Template qu'on utilise pour la page d'accueil et les pages des articles -->

<body>
	<header>
		<h1>Games & Friends</h1>
		<!-- Bouton de connexion/enregistrement/déconnexion -->
		<div id="control">
			<ul>
				<?php
                if (session_status() !== PHP_SESSION_ACTIVE || !isset($_SESSION['playerName'])) { // Si aucune session n'est active on affiche les boutons de connexion et d'enregistrement
                    ?>
				<li id="connexion" class="logBtn1">
					Se connecter
				</li>
				<li id="registration" class="logBtn1">
					S'enregistrer
				</li>
				<?php
                }
            if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['playerName'])) { // Si une session est active on n'affiche que le bouton de déconnexion
                ?>
				<li class="logBtn1">
					<a href="index.php?action=logOut">Déconnexion</a>
				</li>
				<?php
            if ($_SESSION['function'] == 'admin' && (basename($_SERVER['PHP_SELF']) != 'admin.php')) { // Si la session active est administrateur on affiche le bouton d'administration
                ?>
				<li class="logBtn1">
					<a href="index.php?action=admin">Administration</a>
				</li>
				<?php
            }
            }
            if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['playerName']) && (basename($_SERVER['PHP_SELF']) === 'index.php')) {
                ?>
			</ul>
		</div>
		<?php
            }
            if (session_status() !== PHP_SESSION_ACTIVE || !isset($_SESSION['playerName'])) {
                ?>
		<!-- Formulaire de connexion -->
		<div id="logIn" style="display: none;">
			<h2>Se connecter</h2>
			<form method="POST" action="index.php?action=logIn">
				<div class="flexLogIn">
					<label for="userLogin">Login</label>
					<input id="userLogin" class="logField" type="text" name="playerName" />
				</div>
				<div class="flexLogIn">
					<label for="userPassword">Password</label>
					<input id="userPassword" class="logField" type="text" name="password" />
				</div>
				<input type="submit" class="logBtn2" value="Connexion" />
			</form>
		</div>
		<!-- Formulaire d'enregistrement -->
		<div id="signIn" style="display: none;">
			<h2>S'enregistrer</h2>
			<form method="POST" action="index.php?action=signIn">
				<div class="flexLogIn">
					<label for="playerName">Login</label>
					<input id="playerName" type="text" name="playerName" />
				</div>
				<div class="flexLogIn">
					<label for="eMail">E-mail</label>
					<input id="eMail" type="text" name="eMail" />
				</div>
				<div class="flexLogIn">
					<label for="password">Mot de passe</label>
					<input id="password" type="text" name="password" />
				</div>
				<div class="flexLogIn">
					<label for="confirmationPassword">Confirmez votre mot de passe</label>
					<input id="confirmationPassword" type="text" name="confirmationPassword" />
				</div>
				<input type="submit" class="logBtn2" value="S'enregistrer">
			</form>
		</div>
		<?php
            }
	?>
	</header>
	<footer>
		<div>
		</div>
	</footer>
</body>

</html>