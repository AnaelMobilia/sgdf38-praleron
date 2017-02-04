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
 * @brief Fonctions...
 */

/**
 * Tableau associatif numéro / nom mois
 * @return string[]
 */
function getNomsMois() {
    $monArray = [
        '1' => 'Janvier',
        '2' => 'Février',
        '3' => 'Mars',
        '4' => 'Avril',
        '5' => 'Mai',
        '6' => 'Juin',
        '7' => 'Juillet',
        '8' => 'Aôut',
        '9' => 'Septembre',
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
    $jourActuel = date('j');

    $monRetour = '<select name="' . $nomInput . '">' . "\r\n";
    for ($i = 1; $i <= 31; $i++) {
        $monRetour .= '<option value="' . $i . '"';

        // Est-ce le jour actuel ?
        if ($i == $jourActuel) {
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
    // Jour actuel
    $jourActuel = date('n');

    $monRetour = '<select name="' . $nomInput . '">' . "\r\n";
    foreach (getNomsMois() as $key => $value) {
        $monRetour .= '<option value="' . $key . '"';

        // Est-ce le jour actuel ?
        if ($key == $jourActuel) {
            // preselection
            $monRetour .= ' selected="selected"';
        }
        $monRetour .= '>' . $value . '</option>' . "\r\n";
    }
    $monRetour .= '</select>' . "\r\n";

    return $monRetour;
}
