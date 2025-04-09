<?php
    $title = "Tech";
    $description = "Découvrez notre page de développement";
    $h1 = "Bienvenue à la page Tech";
    require_once "./include/functions.inc.php";
    require "./include/header.inc.php";

    $apiKey = "i759zN3mV4bsAYHGJpgiJgiskyiYNdRgRwxudICk";
    $date = date("Y-m-d");
    //$date = "2025-03-02";
    $data = getNasaData($apiKey, $date);

    if ($data) {
        $mediaType = $data["media_type"] ?? "unknown";
        $src = $data["url"] ?? null;
        $srcHd = $data["hdurl"] ?? null;
        $explanation = $data["explanation"] ?? "Pas d'explication disponible.";
        $title = $data["title"] ?? "Titre inconnu.";
        $thumbnailUrl = $data["thumbnail_url"] ?? null;
    } else {
        $error = "Erreur lors de la récupération des données.";
    }

    $ip = getIP();
    $geoData = getGeoData($ip);
    if ($geoData) {
        $country = $geoData->geoplugin_countryName ?? "Inconnu";
        $city = $geoData->geoplugin_city ?? "Inconnue";
    } else {
        $error = "Impossible de récupérer la position géographique.";
    }

    $dataIpinfo = getIpInfo($ip);
    if ($dataIpinfo) {
        $countryIpinfo = $dataIpinfo["country"] ?? "Inconnu";
        $cityIpinfo = $dataIpinfo["city"] ?? "Inconnue";
        $regionIpinfo = $dataIpinfo["region"] ?? "Inconnu";
        $locIpinfo = explode(",", $dataIpinfo["loc"] ?? ",");
        $latitudeIpinfo = $locIpinfo[0] ?? "Inconnu";
        $longitudeIpinfo = $locIpinfo[1] ?? "Inconnu";
    } else {
        $errorIpinfo = "Impossible de récupérer la position géographique via ipinfo.";
    }
?>

<section>
    <?php if (isset($error)): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <h2 lang="en"><?= htmlspecialchars($title) ?></h2>
        <p><?= htmlspecialchars($explanation) ?></p>

        <?php if ($mediaType === "image"): ?>
            <p lang="en">Pour voir l'image en HD : <a href="<?= htmlspecialchars($srcHd) ?>">cliquez ici</a>.</p>
            <img src="<?= htmlspecialchars($src) ?>" alt="NASA APOD" class="nasa-image">

        <?php elseif ($mediaType === "video"): ?>
            <?php if (str_contains($src, 'youtube.com') || str_contains($src, 'vimeo.com')): ?>
                <iframe src="<?= htmlspecialchars($src) ?>" frameborder="0" allowfullscreen style="width: 100%; height: 500px; display: block; margin: auto;"></iframe>
            <?php elseif (!empty($thumbnailUrl)): ?>
                <p>Cette vidéo ne peut pas être intégrée ici. Voici un aperçu :</p>
                <img src="<?= htmlspecialchars($thumbnailUrl) ?>" alt="Aperçu vidéo" class="nasa-image">
                <p><a href="<?= htmlspecialchars($src) ?>" target="_blank">Voir la vidéo complète dans un nouvel onglet</a></p>
            <?php else: ?>
                <p>Vidéo non intégrable. <a href="<?= htmlspecialchars($src) ?>" target="_blank">Clique ici pour la voir</a>.</p>
            <?php endif; ?>

        <?php else: ?>
            <p>Aucune image ou vidéo disponible pour aujourd'hui.</p>
            <figure>
                <img src="images/image_par_default_nasa.jpeg" alt="NASA APOD image par default">
            </figure>
        <?php endif; ?>
    <?php endif; ?>
</section>

<section>
    <h2>Votre géolocalisation</h2>
    <article>
        <h3>Avec l'API geoplugin :</h3>
        <ul>
            <li>Pays : <?= htmlspecialchars($country) ?> </li>
            <li>Ville : <?= htmlspecialchars($city) ?> </li>
        </ul>
    </article>

    <article>
        <h3>Avec l'API ipinfo</h3>
        <?php if (isset($errorIpinfo)): ?>
            <p><?= htmlspecialchars($errorIpinfo) ?></p>
        <?php else: ?>
            <ul>
                <li>Pays : <?= htmlspecialchars($countryIpinfo) ?> </li>
                <li>Région : <?= htmlspecialchars($regionIpinfo) ?> </li>
                <li>Ville : <?= htmlspecialchars($cityIpinfo) ?> </li>
                <li>Latitude : <?= htmlspecialchars($latitudeIpinfo) ?> </li>
                <li>Longitude : <?= htmlspecialchars($longitudeIpinfo) ?> </li>
            </ul>
        <?php endif; ?>
    </article>

    <article>
        <h3>Votre adresse IP :</h3>
        <ul>
            <li>Votre adresse IP est : <?= htmlspecialchars($ip) ?></li>
        </ul>
    </article>
</section>

<?php
    require "./include/footer.inc.php";
?>