<?php
    $title = "Accueil";
    $description = "Découvrez nos TD de développement web";
    $h1 = " ClimaLive";
    require_once "./include/functions.inc.php";
    require "./include/header.inc.php";

    $tableau_image_aleatoire = array(
            1 => "image_aleatoire_1.avif",
        2 => "image_aleatoire_2.avif",
        3 => "image_aleatoire_3.avif",
        4 => "image_aleatoire_4.avif",
    );

    $nbr_aleatoire = random_int(1,4);
    $image_aleatoire = $tableau_image_aleatoire[$nbr_aleatoire];

    $ip = getIP();
    $dataIpinfo = getIpInfo($ip);
    if ($dataIpinfo) {
        $cityIpinfo = $dataIpinfo["city"] ?? "Inconnue";
    }

?>

        <section>
            <h2 >Votre météo en temps réel, aussi changeante que passionnante que la nature elle-même</h2>

                <?php
                $dataIpinfo = getIpInfo($ip);
                if ($dataIpinfo) {
                    $cityIpinfo = $dataIpinfo["city"] ?? "Inconnue";
                    echo "<span><a class='auto_location' href='previsions_ville.php?ville=".$cityIpinfo."'> 📍 Voir la météo à ".$cityIpinfo."</a></span>\n";
                }
                ?>

            <?php
            if (isset($_COOKIE['last_city']) && !empty($_COOKIE['last_city'])) {
                $last_city = $_COOKIE['last_city'];
                $date = $_COOKIE['last_city_date'];

                echo "<span id='last_consultation'>";
                echo "<span class='label'>Dernière ville consultée :</span><br>";
                echo "<span class='ville-lien'><a href='previsions_ville.php?ville=" . htmlspecialchars($last_city) . "'>" . htmlspecialchars($last_city) . "</a></span><br>";
                echo "<span class='date-consultation'>le " . htmlspecialchars($date) . "</span>";
                echo "</span>\n";
            }
            ?>


            <figure>
                <img src="images/aleatoire/<?= $image_aleatoire ?>" style="display: block; margin: 0 auto;" alt="image aléatoire">
            </figure>
        </section>



<?php
    require "./include/footer.inc.php";

?>