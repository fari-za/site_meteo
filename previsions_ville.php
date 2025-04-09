<?php

$description="Page météo de la ville choisie";
$h1="Prévisions Ville";
require_once "./include/functions.inc.php";


$arr_cookie_options = array (
    'expires' => time() + 60*60*24*30,
    'path' => '/',
    'domain' => 'fariza-faradji.alwaysdata.net',

);


$meteo_actuelle = [];
$previsions_heures = [];
$previsions_jours = [];
$message_erreur = "";

    if (!empty($_GET["ville"])) {
        $ville = htmlspecialchars($_GET["ville"]);
        $data = getMeteo($ville, 5); // Récupération des prévisions pour 3 jours

        if ($data && isset($data["current"], $data["forecast"]["forecastday"][0]["hour"])) {
            // Météo actuelle
            $meteo_actuelle = [
                "temperature" => $data["current"]["temp_c"],
                "condition" => $data["current"]["condition"]["text"],
                "icon" => $data["current"]["condition"]["icon"] ,
                "local_time" => $data["location"]["localtime"]
            ];

            $current_time = date("H");

            // Prévisions par heure (seulement à partir de l'heure actuelle)
            foreach ($data["forecast"]["forecastday"][0]["hour"] as $heure) {
                $hour = date("H", strtotime($heure["time"]));
                if ($hour >= $current_time) { // Vérifie si l'heure est paire
                    $previsions_heures[] = [
                        "time" => $hour,
                        "temperature" => $heure["temp_c"],
                        "condition" => $heure["condition"]["text"],
                        "icon" => $heure["condition"]["icon"],
                        "precip_mm" => $heure["precip_mm"],
                        "wind_kph" => $heure["wind_kph"],
                        "pressure_mb" => $heure["pressure_mb"]

                    ];
                }
            }

            // Prévisions pour un jour et les jours suivants
            foreach ($data["forecast"]["forecastday"] as $jour) {
                $previsions_jours[] = [
                    "date" => date("d/m/Y", strtotime($jour["date"])),
                    "temp_min" => $jour["day"]["mintemp_c"],
                    "temp_max" => $jour["day"]["maxtemp_c"],
                    "condition" => $jour["day"]["condition"]["text"],
                    "icon" => $jour["day"]["condition"]["icon"]
                ];
            }


            // Enregistrement du cookie (ville + date de consultation)
            $expire = time() + 60 * 60 * 24 * 30 * 12; // on le garde pendant 1 an
            setcookie('last_city', $ville, $expire, '/');
            setcookie('last_city_date', date("d/m/Y à H:i"), $expire, '/');

        } else {
            $message_erreur = "Impossible de récupérer les données météo.";
        }

    } else {
        $message_erreur = "Impossible de récupérer les données météo.";
    }

    $title="Météo - " .htmlspecialchars($ville ?? "Inconnue");


    // Chemin du fichier CSV pour les villes consultées
    $csvFile = 'villes_consultees.csv';

    // Gestion du compteur global de visiteurs (optionnel)
    $visiteur_file = 'visiteurs.csv';
    if (!file_exists($visiteur_file)) {
        file_put_contents($visiteur_file, "0");
    }
    $visiteurs = (int)file_get_contents($visiteur_file);
    $visiteurs++;
    file_put_contents($visiteur_file, $visiteurs);

    // Récupération de la ville passée en paramètre (GET ou POST)
    $ville = isset($_GET['ville']) ? $_GET['ville'] : '';
    if ($ville !== '') {
        addCity($csvFile, $ville);
    }

require "./include/header.inc.php";
?>


<?php if (!empty($meteo_actuelle)): ?>
<section>
    <h2>Météo à <?= htmlspecialchars($_GET["ville"]) ?></h2>
    <article>
        <h3>Météo du jour</h3>
    <table style="border-collapse: collapse; border: 1px solid black;">
        <tr>
            <td rowspan="4">
                <img src="<?= $meteo_actuelle["icon"] ?>" alt="Icône météo">
            </td>
            <td><strong>Température actuelle :</strong> <?= $meteo_actuelle["temperature"] ?>°C</td>
        </tr>
        <tr><td><strong>Condition :</strong> <?= $meteo_actuelle["condition"] ?></td></tr>
        <tr><td><strong>Pression :</strong> <?= $data["current"]["pressure_mb"] ?> hPa</td></tr>
        <tr><td><strong>Humidité :</strong> <?= $data["current"]["humidity"] ?>%</td></tr>
        <tr><td colspan="2"><strong>Vent :</strong> <?= $data["current"]["wind_kph"] ?> km/h</td></tr>
    </table>
    </article>
    <article>
    <h3>Prévisions sur 5 jours</h3>
    <table style="border: 1px solid black; cellpadding: 10;">
        <tr>
            <?php foreach ($previsions_jours as $jour): ?>
                <th><?= $jour["date"] ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($previsions_jours as $jour): ?>
                <td><img src="<?= $jour["icon"] ?>" alt="Icône météo"></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($previsions_jours as $jour): ?>
                <td><?= $jour["temp_min"] ?>° / <?= $jour["temp_max"] ?>°</td>
            <?php endforeach; ?>
        </tr>
    </table>
    </article>
<?php endif; ?>

<?php if (!empty($previsions_heures)): ?>
    <h3>Évolution des conditions météo</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Heure</th>
            <th>Ciel</th>
            <th>Température</th>
            <th>Pression</th>
            <th>Pluie</th>
            <th>Vent</th>
        </tr>
        <?php foreach ($previsions_heures as $heure): ?>
            <tr>
                <td><?= $heure["time"] ?></td>
                <td><img src="<?= $heure["icon"] ?>" alt="Icône météo"></td>
                <td><?= $heure["temperature"] ?>°C</td>
                <td><?= $heure["pressure_mb"] ?> hPa</td>
                <td><?= $heure["precip_mm"] ?> mm</td>
                <td><?= $heure["wind_kph"] ?> km/h</td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
<?php endif; ?>


<?php
require "./include/footer.inc.php";
?>
