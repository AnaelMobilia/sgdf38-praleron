<?php
/**
 * Copyright 2017 - Anael Mobilia
 *
 * This file is part of sgdf38-praleron.
 *
 * sgdf38-praleron is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * sgdf38-praleron is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with sgdf38-praleron. If not, see <http://www.gnu.org/licenses/>
 */
/**
 * @author Anael Mobilia
 * @brief Affichage de la base
 */
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Réservation de la base de scoutisme de Praléron en Isère</title>
        <style>
            iframe {
                width: 100%;
                min-height: 500px;
            }
        </style>
    </head>
    <body>
        Vous pouvez voir sur la carte ci-dessous les différents terrains de la base. Cliquez sur un terrain pour obtenir ses caractéristiques et des photos.
        <iframe src="https://www.google.com/maps/d/embed?mid=11LLfJuTQQ8zbx_HFWDCfFZ0LHrs"></iframe>

        <br />
        Je veux connaître les disponibilités d'un terrain
        <br />
        Je cherche un terrain disponible à une date précise
    </body>
</html>

<?php

/** Include PHPExcel */
require './PHPExcel/PHPExcel.php';
require './config.php';

// Chargement du fichier
$objPHPExcel = PHPExcel_IOFactory::load(__FILE_FQDN__);
// Pointeur sur ma sheet
$actWorkSheet = $objPHPExcel->getActiveSheet();
echo $actWorkSheet->getCell('A1')->getValue();
