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
 * @brief Configuration centralisée
 */
// Mail de l'administrateur
define('__MAIL_ADMIN__', 'john.doe@example.com');
// Nom du fichier Google Sheets
define('__FILE_KEY__', '0AoFkkLP2MB8kdFd4bEJ5VzR2RVdBQkVuSW91WE1zZkE');

/**
 *  Données calculées automatiquement
 */
// URL de téléchargement du fichier
define('__URL_TELECHARGEMENT__', 'https://docs.google.com/spreadsheets/d/' . __FILE_KEY__ . '/export?format=xlsx&id=' . __FILE_KEY__);
// PATH FQDN du fihier sur le serveur
define('__FILE_FQDN__', 'datas/' . __FILE_KEY__);
