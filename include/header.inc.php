<?php


// Consentement cookies
$cookieConsent = isset($_COOKIE['cookieConsent']) ? $_COOKIE['cookieConsent'] : null;

$arr_cookie_options = array(
    'expires' => time() + 60*60*24*30,
    'path' => '/',
    'domain' => 'fariza-faradji.alwaysdata.net',
);

// Par défaut
$style = "clair";

// Si l'utilisateur a mis le parametre style dans l'URL : on l'utilise toujours
if (isset($_GET["style"]) && ($_GET["style"] === "sombre" || $_GET["style"] === "clair")) {
    $style = $_GET["style"];

    //On le stocke en cookie seulement si l'utilisateur a accepté
    if ($cookieConsent === 'true') {
        setcookie('style', $style, $arr_cookie_options);
    }
}
//Sinon, on lit le cookie uniquement si l'utilisateur a accepté
elseif ($cookieConsent === 'true' && isset($_COOKIE['style']) && !empty($_COOKIE['style'])) {
    $style = $_COOKIE['style'];
}


$theme = ($style === "sombre") ? "sombre" : "clair";
$imageMode = ($style === "sombre") ? "./images/clair.png" : "./images/sombre.png";
$modeChange = "?style=" . ($style === "sombre" ? "clair" : "sombre");
$mode = "?style=" . $style;


?>


<!DOCTYPE html>
<html lang="fr">

<head>
	<title><?=$title?></title>
	<meta charset="UTF-8" />
	<meta name="author" content="Fariza FARADJI" />
	<meta name="description" content="<?=$description?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1"/> 
	<link rel="stylesheet" href="<?=$theme?>.css" />
	<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

	<style>
    .main-nav {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 20px;
        justify-content: flex-end;
    }

	.nasa-image {
		max-width: 100%; 
		height: auto;
		display: block;   
		margin: 0 auto;    
	}
	</style>

    <!-- script pour la barre des cookies + bouton afficher/masquer détails -->
    <script src="script.js"></script>

</head>

<body>

	<header>
		<!-- Barre de navigation horizontale -->
		<nav class="main-nav" style="display: flex; align-items: center; justify-content: space-between;">
			<!-- Logo à gauche -->
			<a href="index.php<?=$mode?>">
				<figure style="margin: 0; padding: 0;">
					<img src="./images/logo.png" alt="Logo du site ClimatLive" style="margin-left : 10px;
					margin-top : 7px"/>
				</figure>
			</a> 

			<!-- Liste des liens de navigation à droite -->
			<ul class="list-nav">
                <li><a href="previsions.php<?=$mode?>"> Prévisions </a></li>
                <li><a href="statistiques.php<?=$mode?>"> Statistiques </a></li>
			</ul>
		</nav>

        <!-- icone changement du mode (sombre/clair) -->
		<span style="position: fixed; bottom: 110px; right: 16px;">
        <a href="<?=$modeChange?>" title="">
            <img src="<?=$imageMode?>" alt="Changer mode" />
        </a>
 	   </span>

        <!-- icone retour en haut de page -->
        <span>
       			<a href="#" title="Retour en haut de page" class="back-to-top">↑</a>
    	</span>
		<h1><?=$h1?></h1>
	</header>

	<main>

        <!-- barre des cookies -->
        <section id="cookie-banner" style="display: none; position: fixed; bottom: 0; left: 25px; width: 50%; background: #333; color: #fff; padding: 15px; text-align: center; z-index: 999;">
            <h2 style="font-size: medium; color: #fff">Ce site utilise des cookies pour améliorer votre expérience.</h2>
            <button onclick="acceptCookies()" style="margin-left: 10px; color: #00D000">Accepter</button>
            <button onclick="refuseCookies()" style="color: red">Refuser</button>
        </section>
