<?php

	/**
	 * Récupère le nom du navigateur utilisé
	 * 
	 * @return string 
	 */
	function get_navigateur() {
		// Récupérer la chaîne User-Agent
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
	
		// Identifier le navigateur et simplifie son nom
		if (strpos($user_agent, 'Chrome') !== false) {
			return 'Google Chrome';
		} elseif (strpos($user_agent, 'Firefox') !== false) {
			return 'Mozilla Firefox';
		} elseif (strpos($user_agent, 'Safari') !== false) {
			return 'Safari';
		} elseif (strpos($user_agent, 'Edge') !== false) {
			return 'Edge';
		} elseif (strpos($user_agent, 'Opera') !== false) {
			return 'Opera';
		} elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
			return 'Internet Explorer';
		} else {
			return 'Navigateur inconnu';
		}
	}


    /**
     * Récupère les informations de localisation à partir de l'API ipinfo
     * @param string $ip L'adresse IP de l'utilisateur.
     * @return array|null Les données JSON de localisation ou null en cas d'erreur.
     */
function getIpInfo(string $ip) {
    $token = "9c0f944045c2f0";
    $url = "https://ipinfo.io/$ip/geo?token=$token";
    $response = file_get_contents($url);

    if ($response == false) {
        return null;
    }

    return json_decode($response, true);
}


    /**
     * Récupère les données de l'API NASA APOD
     *
     * @param string $apiKey Clé API pour la NASA
     * @param string $date Date
     * @return array|null Retourne un tableau contenant les données de l'APOD ou sinon null
     */
    function getNasaData(string $apiKey, string $date) {
        $url = "https://api.nasa.gov/planetary/apod?api_key=". $apiKey ."&date=". $date ."&thumbs=true";
        $response = file_get_contents($url);
        return $response ? json_decode($response, true) : null;
    }

    /**
     * Récupère l'adresse IP de l'utilisateur.
     * @return string L'adresse IP
     */
    function getIP() {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    /**
     * Récupère les données de géolocalisation à partir de l'API geoplugin
     * @param string $ip L'adresse IP de l'utilisateur
     * @return SimpleXMLElement|null Les données XML de géolocalisation ou null en cas d'erreur
     */
    function getGeoData(string $ip) {
        $url = "http://www.geoplugin.net/xml.gp?ip=$ip";
        $xml = simplexml_load_file($url);
        return $xml ?: null;
    }


/**
 * Charge les villes d’un département donné à partir du fichier CSV.
 *
 * @param string $departmentCode Le code du département.
 * @return array Un tableau associatif des villes (code => nom).
 */
function loadCities(string $departmentCode): array {
    $filePath = './include/cities.csv';
    $cities = [];

    if (($handle = fopen($filePath, "r")) !== false) {
        fgetcsv($handle); // Ignorer l'en-tête
        while (($data = fgetcsv($handle)) !== false) {
            // Vérifier si le code du département correspond
            if ($data[1] === $departmentCode) {
                // Utiliser le code de la ville comme clé et le nom comme valeur
                $cities[$data[2]] = $data[4];
            }
        }
        fclose($handle);
    }
    return $cities;
}

/**
 * Charge les régions à partir du fichier CSV.
 *
 * @return array Un tableau associatif des régions (code => nom).
 */
function loadRegions(): array {
    $filePath = './include/regions.csv';
    $regions = [];

    if (($handle = fopen($filePath, "r")) !== false) {
        fgetcsv($handle); // Ignorer l'en-tête
        while (($data = fgetcsv($handle)) !== false) {
            // Utiliser le code de la région comme clé et le nom comme valeur
            $regions[$data[1]] = $data[2];
        }
        fclose($handle);
    }

    return $regions;
}

/**
 * Charge les départements appartenant à une région donnée.
 *
 * @param string $regionCode Le code de la région.
 * @return array Un tableau associatif des départements (code => nom).
 */
function loadDepartments(string $regionCode): array {
    $filePath = './include/departments.csv';
    $departments = [];

    if (($handle = fopen($filePath, "r")) !== false) {
        fgetcsv($handle); // Ignorer l'en-tête
        while (($data = fgetcsv($handle)) !== false) {
            // Vérifier si le département appartient à la région demandée
            if ($data[1] === $regionCode) {
                // Utiliser le code du département comme clé et le nom comme valeur
                $departments[$data[2]] = $data[3];
            }
        }
        fclose($handle);
    }
    return $departments;
}


/**
 * Génère les options HTML pour le menu déroulant des régions.
 *
 * @param string $selectedRegion Le code de la région sélectionnée (facultatif).
 * @return void
 */
function generateRegionOption($selectedRegion = '') {
	$regions = loadRegions();
	foreach ($regions as $code => $name) {
		// Utilisation de == pour permettre la comparaison même si l'un est un nombre et l'autre une chaîne
		$selected = ($code == $selectedRegion) ? 'selected' : '';
		$l="<option value='" .$code. "' " .$selected.">".$name."</option>";
		echo $l;
	}
}


/**
 * Génère les options HTML pour le menu déroulant des départements.
 *
 * @param string $regionCode Le code de la région.
 * @param string $selectedDepartment Le code du département sélectionné.
 * @return void
 */
function generateDepartmentOption($regionCode, $selectedDepartment = '') {
    $departments = loadDepartments($regionCode);
    foreach ($departments as $code => $name) {
        $selected = ($code == $selectedDepartment) ? 'selected' : '';
        echo "<option value='" .$code. "'  " .$selected. ">" .$name. "</option>";
    }
}

/**
* Génère les options HTML pour le menu déroulant des villes.
*
* @param string $departmentCode Le code du département.
* @return void
*/
function generateCityOption($departmentCode) {
    $cities = loadCities($departmentCode);
    asort($cities);
    foreach ($cities as $code => $name) {
        echo "<option value='".$name."'>".$name."</option>";
    }
}

/**
 * Récupère les prévisions météo d'une ville en appelant l'API WeatherAPI.
 *
 * @param string $ville Le nom de la ville.
 * @param int $days Le nombre de jours de prévision (par défaut 5).
 * @return array|null Les données météo décodées ou null en cas d’erreur.
 */
function getMeteo(string $ville, int $days = 5) {
    $apiKey = "d2d407005de641c688f95501252803";
    $ville=removeAccents($ville);
    $url = "https://api.weatherapi.com/v1/forecast.json?key=" . $apiKey . "&q=" . urlencode($ville) . "&days=" . $days . "&lang=fr&units=metric";
    $response = file_get_contents($url);

    if ($response) {
        return json_decode($response, true);
    } else {
        return null;
    }
}

/**
 * Supprime les accents d’une chaîne de caractères.
 *
 * @param string $string La chaîne d’entrée.
 * @return string La chaîne sans accents.
 */
function removeAccents($string) {
    return strtr(
        iconv('UTF-8', 'ASCII//TRANSLIT', $string),
        ['`' => '', '´' => '', 'ˆ' => '', '¨' => '', '˜' => '']
    );
}

////////////// statistiques :

/**
 * Récupère les données du fichier CSV de statistiques des villes.
 *
 * @param string $csvFile Le chemin vers le fichier CSV.
 * @return array Tableau des lignes du fichier CSV.
 */
function getCitiesData($csvFile) {
    $data = [];
    if (file_exists($csvFile)) {
        if (($handle = fopen($csvFile, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                // On s'assure que la ligne comporte 2 colonnes
                if (isset($row[0]) && isset($row[1])) {
                    $data[] = $row;
                }
            }
            fclose($handle);
        }
    }
    return $data;
}

/**
 * Calcule le nombre total de consultations toutes villes confondues.
 *
 * @param string $csvFile Le chemin vers le fichier CSV.
 * @return int Le nombre total de consultations.
 */
function getVisitCount($csvFile) {
    $data = getCitiesData($csvFile);
    $total = 0;
    foreach ($data as $row) {
        $total += (int)$row[1];
    }
    return $total;
}

/**
 * Ajoute une ville ou incrémente son compteur dans le fichier CSV
 *
 * @param string $csvFile Le chemin vers le fichier CSV.
 * @param string $city Le nom de la ville
 * @return void
 */
function addCity($csvFile, $city) {
    $data = getCitiesData($csvFile);
    $found = false;

    // Vérifier si la ville existe déjà et mettre à jour son compteur
    foreach ($data as &$row) {
        if ($row[0] === $city) {
            $row[1] = (int)$row[1] + 1;
            $found = true;
            break;
        }
    }
    unset($row);

    // Si la ville n'existe pas, on l'ajoute
    if (!$found) {
        $data[] = [$city, 1];
    }

    // Réécriture complète du fichier CSV
    if (($handle = fopen($csvFile, 'w')) !== false) {
        fputcsv($handle, ['city_name', 'consultation_count']);
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }
}

?>