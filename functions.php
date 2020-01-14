<?php
/**
 * Copyright 2017-2020 - Anael Mobilia
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
 * @brief Fonctions...
 */

/**
 * Tableau associatif numéro / nom mois
 * @return string[]
 */
function getNomsMois() {
    $monArray = [
        '01' => 'Janvier',
        '02' => 'Février',
        '03' => 'Mars',
        '04' => 'Avril',
        '05' => 'Mai',
        '06' => 'Juin',
        '07' => 'Juillet',
        '08' => 'Août',
        '09' => 'Septembre',
        '10' => 'Octobre',
        '11' => 'Novembre',
        '12' => 'Décembre'
    ];

    return $monArray;
}

/**
 * Liste déroulante de tous les jours avec préselection du jour actuel
 * @param type $nomInput nom du input
 * @return code html
 */
function getListeJours($nomInput) {
    // Jour actuel
    $jourSelect = date('j');
    // Surchargé par la saisie déjà effectuée le cas échéant
    if (isset($_GET[$nomInput])) {
        $jourSelect = $_GET[$nomInput];
    }

    $monRetour = '<select class="form-control" name="' . $nomInput . '">' . "\r\n";
    for ($i = 1; $i <= 31; $i++) {
        // Notation sur deux chiffres
        if ($i < 10) {
            // Préfixage pour les premiers nombres
            $index = '0' . $i;
        } else {
            $index = $i;
        }

        $monRetour .= '<option value="' . $index . '"';

        // Est-ce le jour actuel ?
        if ($i == $jourSelect) {
            // preselection
            $monRetour .= ' selected="selected"';
        }

        $monRetour .= '>' . $i . '</option>' . "\r\n";
    }
    $monRetour .= '</select>' . "\r\n";

    return $monRetour;
}

/**
 * Liste déroulante de tous les jours avec préselection du jour actuel
 * @param type $nomInput nom du input
 * @return code html
 */
function getListeMois($nomInput) {
    // Mois actuel
    $moisSelect = $moisActuel = date('n');
    // Surchargé par la saisie déjà effectuée le cas échéant
    if (isset($_GET[$nomInput])) {
        $moisSelect = substr($_GET[$nomInput], -3, 2);
    }

    // Année actuelle
    $anneeActuelle = date('Y');

    $monRetour = '<select class="form-control" name="' . $nomInput . '">' . "\r\n";
    foreach (getNomsMois() as $key => $value) {
        // Gestion de l'année (pas de réservation dans le passé)
        if ($key >= $moisActuel) {
            $annee = $anneeActuelle;
        } else {
            $annee = $anneeActuelle + 1;
        }

        $monRetour .= '<option value="' . $annee . '/' . $key . '/' . '"';

        // Est-ce le mois actuel ?
        if ($key == $moisSelect) {
            // preselection
            $monRetour .= ' selected="selected"';
        }
        $monRetour .= '>' . $value . ' ' . $annee . '</option>' . "\r\n";
    }
    $monRetour .= '</select>' . "\r\n";

    return $monRetour;
}

/**
 * Terrains disponibles aux dates fournies
 * @param DateTime $dateDebut Date de début
 * @param DateTime $dateFin   Date de fin
 * @return string[] Nom des terrains disponibles
 */
function getTerrainDispo($dateDebut, $dateFin) {
    // Chargement PHPExcel
    require './PHPExcel/PHPExcel.php';

    /**
     * Chargement du fichier de données
     */
    // Identification du type du fichier
    $typeFichier = PHPExcel_IOFactory::identify(__FILE_FQDN__);

    // Création d'un objet PHP Excel pour mon type de fichier
    $objPHPExcel = PHPExcel_IOFactory::createReader($typeFichier);
    // Je ne veux que les données, pas le formatage
    //$objPHPExcel->setReadDataOnly(true);
    // Chargement du fichier
    $monFichier = $objPHPExcel->load(__FILE_FQDN__);

    // Feuille PLANNING
    $lePlanning = $monFichier->setActiveSheetIndexByName(__SHEET_ONGLET_PLANNING__);
    // Feuille CONFIGURATION
    $laConfiguration = $monFichier->setActiveSheetIndexByName(__SHEET_ONGLET_CONFIG__);

    /**
     * Récupération de la première date dans le fichier
     */
    $firstDate = $lePlanning->getCellByColumnAndRow(__SHEET_PLANNING_COLONNE_DATES__, __SHEET_PLANNING_LIGNE_DATES__)->getFormattedValue();
    // Formatage pour Datetime (YYYY/MM/DD)
    $premiereDate = new DateTime(substr($firstDate, 6) . substr($firstDate, 2, 4) . substr($firstDate, 0, 2));

    /**
     * Calcul des indices des lignes
     */
    $ligneDebut = $premiereDate->diff($dateDebut)->days + __SHEET_PLANNING_LIGNE_DATES__;
    $ligneFin = $ligneDebut + $dateDebut->diff($dateFin)->days;

    /**
     * Récupération de la liste de tous les lieux
     */
    $listeLieux = new ArrayObject();
    // Première colonne
    $i = __SHEET_PLANNING_PREMIERE_COLONNE_TERRAINS__;
    // Tant que j'ai un nom de terrain...
    while (($nomLieu = $lePlanning->getCellByColumnAndRow($i, __SHEET_PLANNING_LIGNE_TERRAINS__)->getValue()) !== NULL) {
        // Je le stocke !
        $listeLieux->offsetSet($i, $nomLieu);
        // Et passe à la colonne suivante
        $i++;
    }

    /**
     * Vérification que les dates demandées sont bien disponibles !
     */
    if ($lePlanning->getCellByColumnAndRow(__SHEET_PLANNING_COLONNE_DATES__, $ligneFin)->getValue() === NULL) {
        // Sinon, on trashe !
        $listeLieux = new ArrayObject();
    }

    /**
     * Vérification de la cohérence des dates demandées
     */
    if ($ligneFin < $ligneDebut) {
        // Sinon, on trashe !
        $listeLieux = new ArrayObject();
    }

    /**
     * Suppression des lieux systématiquement indisponibles !
     */
    // Nouvel objet pour éviter de modifier une liste qu'on itère...
    $newList = new ArrayObject($listeLieux->getArrayCopy());
    // Pour chaque lieu...
    foreach ($listeLieux as $key => $value) {
        // Je regarde s'il est taggué systématiquement indisponible
        if ($laConfiguration->getCellByColumnAndRow($key, __SHEET_CONFIG_LIGNE_INDISPO_DEFAUT__)->getValue() !== NULL) {
            // Si oui, je ne le prends pas !
            $newList->offsetUnset($key);
        }
    }
    $listeLieux = new ArrayObject($newList->getArrayCopy());

    /**
     * Suppression des lieux pour lesquels on est dans les dates d'indisponibilités
     */
    // Nouvel objet pour éviter de modifier une liste qu'on itère...
    $newList = new ArrayObject($listeLieux->getArrayCopy());
    // Pour chaque lieux restant...
    foreach ($listeLieux as $key => $value) {
        // Valeur formattée (date)
        $debIndispo = $laConfiguration->getCellByColumnAndRow($key, __SHEET_CONFIG_LIGNE_DATE_DEB_INDISPO__)->getFormattedValue();
        $finIndispo = $laConfiguration->getCellByColumnAndRow($key, __SHEET_CONFIG_LIGNE_DATE_FIN_INDISPO__)->getFormattedValue();

        // Seulement si on a des valeurs !
        if ($debIndispo !== '' && $finIndispo !== '') {
            // Découpage des dates en fonction des slashs
            $debExplode = explode('/', $debIndispo);
            $jourDebut = $debExplode[0];
            $moisDebut = $debExplode[1];
            $finExplode = explode('/', $finIndispo);
            $jourFin = $finExplode[0];
            $moisFin = $finExplode[1];

            // Année actuelle...
            $anneeDebut = $anneeFin = date('Y');

            // Les mois sont déjà passés....
            if ($moisDebut < date('n') && $moisFin < date('n')) {
                // Ce mois est déjà passé => année suivante
                $anneeDebut++;
            }

            // On est entre les deux mois...
            // => Le cas par défaut reste sur l'année !

            // A cheval fin d'année... -> nouvelle année [période déjà passée !]
            if ($moisFin < $moisDebut && $moisDebut < date('n')) {
                // => Année suivante
                $anneeFin = $anneeDebut + 1;
            }

            // A cheval fin d'année... -> nouvelle année [période non passée !]
            if ($moisFin < $moisDebut && date('n') < $moisDebut) {
                // => Année précédente pour le début
                $anneeDebut--;
            }

            // Création des datetime
            $dateIndispoDebut = new DateTime($anneeDebut . '/' . $moisDebut . '/' . $jourDebut);
            $dateIndispoFin = new DateTime($anneeFin . '/' . $moisFin . '/' . $jourFin);

            // dateDebutIndispo < dateDebut < dateFinIndispo
            // || dateDebutIndispo < dateFin < dateFinIndispo
            if (($dateIndispoDebut->getTimestamp() < $dateDebut->getTimestamp() && $dateDebut->getTimestamp() < $dateIndispoFin->getTimestamp()) || ($dateIndispoDebut->getTimestamp() < $dateFin->getTimestamp() && $dateFin->getTimestamp() < $dateIndispoFin->getTimestamp())) {
                // Suppression du lieux
                $newList->offsetUnset($key);
            }
        }
    }
    $listeLieux = new ArrayObject($newList->getArrayCopy());

    /**
     * On regarde dans les lieux restants s'ils sont disponibles ! ;-)
     */
    // Nouvel objet pour éviter de modifier une liste qu'on itère...
    $newList = new ArrayObject($listeLieux->getArrayCopy());
    foreach ($listeLieux as $key => $value) {
        // Je passe chaque date dans l'intervalle demandée [tolérance d'un jour]
        for ($i = $ligneDebut + 1; $i < $ligneFin; $i++) {
            // Si la cellule contient des données
            if ($lePlanning->getCellByColumnAndRow($key, $i)->getValue() !== NULL) {
                // Lieu déjà réservé => non disponible !
                $newList->offsetUnset($key);
                // Sortie rapide du for
                break;
            }
        }
    }
    $listeLieux = new ArrayObject($newList->getArrayCopy());

    // Feuille du planning
    return $listeLieux;
}
