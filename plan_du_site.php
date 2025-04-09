<?php
    $title="Plan";
    $description="la solution du td5 de dev web";
    $h1="Plan du site";
    require_once "./include/functions.inc.php";
    require "./include/header.inc.php";

    if (isset($_GET["style"]) && !empty($_GET["style"])) {
		$style = $_GET["style"];
	} else {
		$style = "clair"; // Valeur par défaut
	}

	$theme = ($style === "nuit") ? "sombre" : "clair";
	$mode = "?style=" . $style;

	$language = "";
	if(isset($_GET["lang"]) && !empty($_GET["lang"])){
		$lang = $_GET["lang"];
		if($lang === "en"){
			$language="&amp;lang=en";
		}
	}
?>
    <section>
        <h2>Naviguer dans les différentes pages du site</h2>
        <ul>
				<li><a href="index.php<?=$mode.$language?>" style="font-weight: bold;">Accueil</a></li>
				<li><a href="tech.php<?=$mode.$language?>" style="font-weight: bold;">Tech</a></li>
                <li><a href="previsions.php<?=$mode.$language?>" style="font-weight: bold;">Prévisions</a></li>
                <li><a href="statistiques.php<?=$mode.$language?>" style="font-weight: bold;">Statistiques</a></li>
		</ul>
    </section>

<?php
    require "./include/footer.inc.php";
?>