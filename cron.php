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
 * @brief Copie locale de fichier Google Sheet pour accélerer les performances
 */
require __DIR__ . '/config.php';

// Récupération du fichier
$file = file_get_contents(__URL_TELECHARGEMENT__);
// Enregistrement en local
file_put_contents(__FILE_FQDN__, $file);

// Vérification du bon téléchargement
if ($file === FALSE || filesize(__FILE_FQDN__) < 1024) {
    // Envoi d'un mail en cas d'erreur
    mail(__MAIL_ADMIN__, 'Erreur de cron praleron', '');
}