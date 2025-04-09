<?php
    $title="Statistiques";
    $description="La page des statistiques ";
    $h1="Les statistiques des villes consultées";
    require_once "./include/functions.inc.php";
    require "./include/header.inc.php";


    $csvFile = 'villes_consultees.csv';
    $citiesData = getCitiesData($csvFile);

    // Récupérer les consultations par ville
    $villesCount = [];
    foreach ($citiesData as $row) {
        $villesCount[$row[0]] = (int)$row[1];
    }

    // Trier par ordre décroissant
    arsort($villesCount);

    // Garder les 5 villes les plus consultées
    $villesTop = array_slice($villesCount, 0, 5, true);

    // Récupérer le nombre total de consultations
    $totalConsultations = getVisitCount($csvFile);

    // Trouver la valeur max pour l’échelle des barres
    $maxCount = max($villesTop);
    ?>

<section>
    <p>Total de consultations : <?php echo $totalConsultations; ?></p>

    <h2>Top 5 des villes les plus consultées</h2>

    <?php foreach ($villesTop as $ville => $nb):
        // Calculer la largeur
        $pourcentage = ($nb / $maxCount) * 100;
        ?>
        <div class="bar-container">
            <div class="label"><?php echo htmlspecialchars($ville); ?> (<?php echo $nb; ?>)</div>
            <div class="bar" style="width: <?php echo $pourcentage; ?>%;">
                <?php echo $nb; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>


<?php
require "./include/footer.inc.php";
?>