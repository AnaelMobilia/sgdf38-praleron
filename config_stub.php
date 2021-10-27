<?php
/**
 * Copyright 2017-2021 - Anael Mobilia
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
 * @brief Configuration centralisée
 */
/**
 * Données à configurer
 */
// Mail de l'administrateur
define('__MAIL_ADMIN__', 'john.doe@example.com');
// Mail du gestionnaire de la base
define('__MAIL_GESTIONNAIRE__', 'john.doe@example.com');
// Nom du fichier Google Sheets
define('__FILE_KEY__', '0AoFkkLP2MB8kdFd4bEJ5VzR2RVdBQkVuSW91WE1zZkE');

/**
 * Données liées au fichier Google Sheet
 */
// PLANNING
define('__SHEET_ONGLET_PLANNING__', 'PLANNING');
define('__SHEET_PLANNING_LIGNE_TERRAINS__', '1');
// Notation numérique : A => 0, B => 1, ...
define('__SHEET_PLANNING_COLONNE_DATES__', '0');
define('__SHEET_PLANNING_PREMIERE_COLONNE_TERRAINS__', '1');
// CONFIGURATION
define('__SHEET_ONGLET_CONFIG__', 'CONFIGURATION');
define('__SHEET_CONFIG_LIGNE_INDISPO_DEFAUT__', '2');
define('__SHEET_CONFIG_LIGNE_DATE_DEB_INDISPO__', '3');
define('__SHEET_CONFIG_LIGNE_DATE_FIN_INDISPO__', '4');

/**
 *  Données calculées automatiquement
 */
// URL de téléchargement du fichier
define('__URL_TELECHARGEMENT__', 'https://docs.google.com/spreadsheets/d/' . __FILE_KEY__ . '/export?format=xlsx&id=' . __FILE_KEY__);
// PATH FQDN du fihier sur le serveur
define('__FILE_FQDN__', __DIR__ . '/datas/' . __FILE_KEY__);

/**
 * Gestion des erreurs
 */
function exception_handler($exception)
{
    /**
     * Envoi d'un mail avec le détail de l'erreur à l'administrateur
     */
    // Adresse expediteur
    $headers = 'From: ' . __MAIL_ADMIN__ . "\n";
    // Adresse de retour
    $headers .= 'Reply-To: ' . __MAIL_ADMIN__ . "\n";
    // Date
    $headers .= 'Date: ' . date('D, j M Y H:i:s +0200') . "\n";
    $message = $exception->getMessage() . "\r\n" . $exception->getTraceAsString();
    $message .= "\r\nURL : " . $_SERVER['REQUEST_URI'];
    if (isset($_SERVER['HTTP_REFERER'])) {
        $message .= "\r\nHTTP REFERER : " . $_SERVER['HTTP_REFERER'];
    }
    $message .= "\r\nHTTP USER AGENT : " . $_SERVER['HTTP_USER_AGENT'];
    $message .= "\r\nREMOTE ADDR : " . $_SERVER['REMOTE_ADDR'];

    mail(__MAIL_ADMIN__, '[Praleron-Reservation] Erreur rencontrée', $message, $headers);
}
set_exception_handler('exception_handler');

require 'functions.php';
