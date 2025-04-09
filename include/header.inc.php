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

// 1. Si l'utilisateur a mis ?style dans l'URL → on l'utilise toujours
if (isset($_GET["style"]) && ($_GET["style"] === "sombre" || $_GET["style"] === "clair")) {
    $style = $_GET["style"];

    // 2. On le stocke en cookie **seulement si l'utilisateur a accepté**
    if ($cookieConsent === 'true') {
        setcookie('style', $style, $arr_cookie_options);
    }
}
// 3. Sinon, on lit le cookie uniquement si l'utilisateur a accepté
elseif ($cookieConsent === 'true' && isset($_COOKIE['style']) && !empty($_COOKIE['style'])) {
    $style = $_COOKIE['style'];
}


$theme = ($style === "sombre") ? "sombre" : "clair";
$imageMode = ($style === "sombre") ? "./images/clair.png" : "./images/sombre.png";
$modeChange = "?style=" . ($style === "sombre" ? "clair" : "sombre");
$mode = "?style=" . $style;


$arr_cookie_options = array (
    'expires' => time() + 60*60*24*30,
    'path' => '/',
    'domain' => 'fariza-faradji.alwaysdata.net',
);

if (isset($_GET["style"]) && !empty($_GET["style"])) {
    if ($_GET["style"] === "sombre" || $_GET["style"] === "clair") {
        $style = $_GET["style"];
        setcookie('style', $style, $arr_cookie_options);
    }
} elseif (isset($_COOKIE['style']) && !empty($_COOKIE['style'])) {
    $style = $_COOKIE['style'];
} else {
    $style = "clair"; // Valeur par défaut
}

$theme = ($style === "sombre") ? "sombre" : "clair";
$imageMode = ($style === "sombre") ? "./images/clair.png" : "./images/sombre.png";
$modeChange = "?style=" . ($style === "sombre" ? "clair" : "sombre");
$mode = "?style=" . $style;

$lang = "fr";
$language = "";
if (isset($_GET["lang"]) && !empty($_GET["lang"])) {
    if ($_GET["lang"] === "en") {
        $lang = "en";
        $language = "&amp;lang=en";
    }
}
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

</head>

<body>
	<header>
		<!-- Barre de navigation horizontale -->
		<nav class="main-nav" style="display: flex; align-items: center; justify-content: space-between;">
			<!-- Logo à gauche -->
			<a href="index.php<?=$mode.$language?>">
				<figure style="margin: 0; padding: 0;">
					<img src="./images/logo.png" alt="Logo du site ClimatLive" style="margin-left : 10px;
					margin-top : 7px"/>
				</figure>
			</a> 

			<!-- Liste des liens de navigation à droite -->
			<ul class="list-nav">
                <li><a href="previsions.php<?=$mode.$language?>">Prévisions</a></li>
                <li><a href="statistiques.php<?=$mode.$language?>">Statistiques</a></li>
				<?php if ($lang === "en") : ?>
				<li><a href="<?= $mode ?>&amp;lang=fr" title="Français"><img src="./images/fr_flag.png" alt="Français" /></a></li>
				<?php else : ?>
				<li><a href="<?= $mode ?>&amp;lang=en" title="English"><img src="./images/en_flag.png" alt="English" /></a></li>
				<?php endif; ?>

			</ul>
		</nav>


		<span style="position: fixed; bottom: 110px; right: 16px;">
        <a href="<?=$modeChange.$language?>" title="">
            <img src="<?=$imageMode?>" alt="Changer mode" />
        </a>
 	   </span>

	    <span>
       			<a href="#" title="Retour en haut de page" class="back-to-top">↑</a>
    	</span>
		<h1><?=$h1?></h1>
	</header>

	<main>