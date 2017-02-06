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
require './config.php';
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
            label {
                display: block;
                width: 200px;
                float: left;
            }
            br {
                clear: both;
            }
        </style>
    </head>
    <body>
        Cliquez sur un terrain pour obtenir ses caractéristiques et des photos.
        <iframe src="https://www.google.com/maps/d/embed?mid=11LLfJuTQQ8zbx_HFWDCfFZ0LHrs"></iframe>

        <br />
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
            Les dates de mon camp sont du &nbsp;
            <?= getListeJours('jourDeb') ?>
            <?= getListeMois('anMoisDeb') ?>
            &nbsp;au&nbsp;
            <?= getListeJours('jourFin') ?>
            <?= getListeMois('anMoisFin') ?>
            <input name = "submit" type="submit" value="Voir les terrains disponibles" />
        </form>
        <?php
        // Formulaire de disponibilités
        if (isset($_GET['submit'])) {
            $dateDeb = new DateTime($_GET['anMoisDeb'] . $_GET['jourDeb']);
            $dateFin = new DateTime($_GET['anMoisFin'] . $_GET['jourFin']);
            $result = getTerrainDispo($dateDeb, $dateFin);
            $nbResult = count($result);
            if ($nbResult == 0) :
                ?>
        Aucun terrain n'est disponible à ces dates !
                <br />
                N'hésitez pas à nous contacter quand même via le formulaire pour que nous voyons ce que nous pouvons faire pour votre séjour !
            <?php else : ?>
                <?php if ($nbResult == 1) : ?>
                    A ces dates est disponible le terrain :
                <?php else : ?>
                    A ces dates sont disponibles les terrains :
                <?php endif; ?>
                <br />
                <ul>
                    <?php foreach ($result as $unTerrain) : ?>
                        <li><?= $unTerrain ?></li>
                    <?php endforeach; ?>
                </ul>
                <br />
                Merci d'utiliser le formulaire ci-dessous si vous souhaitez effectuer une demande de réservation !
            <?php endif; ?>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <label for='nomAssociation'>Association</label>
                <input type='text' name='nomAssociation' id='nomAssociation' />
                <br />
                <label for='dateDebutSejour'>Début du séjour</label>
                <input type='text' name='dateDebutSejour' id='dateDebutSejour' value='<?= $dateDeb->format('d/m/Y') ?>'/>
                <br />
                <label for='dateFinSejour'>Fin du séjour</label>
                <input type='text' name='dateFinSejour' id='dateFinSejour' value='<?= $dateFin->format('d/m/Y') ?>'/>
                <br />
                <label for='nomContact'>Votre nom</label>
                <input type='text' name='nomContact' id='nomContact' />
                <br />
                <label for='mailContact'>Votre mail</label>
                <input type='text' name='mailContact' id='mailContact' />
                <br />
                <label for='telephoneContact'>Votre téléphone</label>
                <input type='text' name='telephoneContact' id='telephoneContact' />
                <br />
                <label for='terrainSouhaite'>Terrain idéalement souhaité</label>
                <input type='text' name='terrainSouhaite' id='terrainSouhaite' />
                <br />
                <label for='nombrePersonnes'>Nombre estimés de personnes <em>(enfants et adultes)</em></label>
                <input type='text' name='nombrePersonnes' id='nombrePersonnes' />
                <br />
                <label for='nombreTentes'>Nombre estimés de tentes</label>
                <input type='text' name='nombreTentes' id='nombreTentes' />
                <br />
                <input type='submit' name='envoiMail' value='Envoyer'/>
            </form>
            <?php
        }
        // Formulaire de réservation
        if (isset($_GET['envoiMail'])) {
            $corps = 'Une nouvelle demande de réservation a été formulée via le site :' . "\r\n";
            foreach ($_GET as $key => $value) {
                // On ne prend pas la balise d'envoi du mail ... ;)
                if ($key != 'envoiMail') {
                    // On ajoute des espaces dans le nom de la clef
                    $corps .= preg_replace('#([A-Z])#', ' $0', $key);
                    // Séparateur...
                    $corps .= ' : ';
                    // La valeur
                    $corps .= $value . "\r\n";
                }
            }
            mail(__MAIL_GESTIONNAIRE__, utf8_decode('Demande de réservation de Praléron'), utf8_decode($corps));
            echo "Votre demande a bien été envoyée, nous vous en remercions.<br />L'équipe Praléron.";
        }
        ?>
    </body>
</html>
