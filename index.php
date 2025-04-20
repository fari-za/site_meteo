<?php
    $title = "Accueil";
    $description = "Découvrez nos TD de développement web";
    $h1 = " ClimaLive";
    require_once "./include/functions.inc.php";
    require "./include/header.inc.php";

    $tableau_image_aleatoire = array(

            6 => "image_aleatoire_6.avif",
            7 => "image_aleatoire_7.avif",
            8 => "image_aleatoire_8.avif",
            9 => "image_aleatoire_9.avif",
            10 => "image_aleatoire_10.avif",
            11 => "image_aleatoire_11.avif",
            12 => "image_aleatoire_12.avif",

    );

    $nbr_aleatoire = random_int(6, 12);
    if(isset($_COOKIE["dernier_nbr_aleatoire"])) {
        $dernier_nbr_aleatoire = $_COOKIE["dernier_nbr_aleatoire"];
        while ($nbr_aleatoire == $dernier_nbr_aleatoire) {
            $nbr_aleatoire = random_int(6, 12);
        }
    }

    setcookie('dernier_nbr_aleatoire', $nbr_aleatoire, $arr_cookie_options);
    $image_aleatoire = $tableau_image_aleatoire[$nbr_aleatoire];

    $ip = getIP();
    $dataIpinfo = getIpInfo($ip);
    if ($dataIpinfo) {
        $cityIpinfo = $dataIpinfo["city"] ?? "Inconnue";
    }

?>

        <section style="background-image: url(images/aleatoire/<?= $image_aleatoire?>);     background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                height: 75vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: white;
                ">
            <h2 style="color: black; text-shadow: 0 0 8px white;" >Votre météo en temps réel</h2>

            <article id="acces_rapides">
                <h3 style="color: white; font-size: 1.2em;">Accès rapides</h3>

                <?php
                $dataIpinfo = getIpInfo($ip);
                if ($dataIpinfo) {
                    $cityIpinfo = $dataIpinfo["city"] ?? "Inconnue";
                    echo "<span><a class='auto_location' href='previsions_ville.php?ville=".$cityIpinfo."'> 📍 Voir la météo à ".$cityIpinfo."</a></span>\n";
                }
                ?>

            <?php
                if (isset($_COOKIE['last_city']) && !empty($_COOKIE['last_city'] && $cookieConsent === 'true')) {
                    $last_city = $_COOKIE['last_city'];
                    $date = $_COOKIE['last_city_date'];

                    $l= "<span id='last_consultation'>";
                    $l.= "<span class='label_ville'>Dernière ville consultée :  </span>";
                    $l.= "<span class='ville-lien'><a href='previsions_ville.php?ville=" . htmlspecialchars($last_city) . "'>" . htmlspecialchars($last_city) . "</a></span>";
                    $l.= "<span class='date-consultation'>le " . htmlspecialchars($date) . "</span>";
                    $l.= "</span>\n \n";
                    echo $l;
                }
            ?>
            </article>

        </section>

<?php
    require "./include/footer.inc.php";
?>