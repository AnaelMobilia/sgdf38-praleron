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
        <!-- Reprises des CSS du site pour l'intégration visuelle -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel='stylesheet' type='text/css' href='http://www.sgdf38.fr/css/styles.css'>
        <style>
            iframe {
                width: 100%;
                min-height: 500px;
            }
            html {
                width: 99%;
            }
        </style>
    </head>
    <body>
        Cliquez sur un terrain pour obtenir ses caractéristiques et des photos.
        <br />
        <br />
        <iframe src="https://www.google.com/maps/d/embed?mid=11LLfJuTQQ8zbx_HFWDCfFZ0LHrs"></iframe>
        <br />
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" class="form-inline">
            <fieldset>
                Les dates de mon camp sont du &nbsp;
                <?= getListeJours('jourDeb') ?>
                <?= getListeMois('anMoisDeb') ?>
                &nbsp;au&nbsp;
                <?= getListeJours('jourFin') ?>
                <?= getListeMois('anMoisFin') ?>
                <input name="submit" type="submit" value="Voir les terrains disponibles" class="btn submit" />
            </fieldset>
        </form>
        <?php
        // Formulaire de disponibilités
        if (isset($_GET['submit'])) {
            $dateDeb = new DateTime($_GET['anMoisDeb'] . $_GET['jourDeb']);
            $dateFin = new DateTime($_GET['anMoisFin'] . $_GET['jourFin']);
            $result = getTerrainDispo($dateDeb, $dateFin);
            $nbResult = count($result);
            ?>
        <fieldset>
                <?php if ($nbResult == 0) : ?>
                    Aucun terrain n'est disponible à ces dates !
                    <br />
                    N'hésitez pas à nous contacter quand même via le formulaire pour que nous voyons ce que nous pouvons faire pour votre séjour !
                <?php else : ?>
                    <legend>
                        <?php if ($nbResult == 1) : ?>
                            Terrain disponible à ces dates :
                        <?php else : ?>
                            Terrains disponibles à ces dates :
                        <?php endif; ?>
                    </legend>
                    <ul>
                        <?php foreach ($result as $unTerrain) : ?>
                            <li><?= $unTerrain ?></li>
                        <?php endforeach; ?>
                    </ul>
                </fieldset>
            <?php endif; ?>
            <fieldset>
                <legend>Effectuer une demande de réservation :</legend>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" class="form-horizontal">
                    <div class="form-group">
                        <label for='nomAssociation' class="col-md-6 control-label">Association</label>
                        <div class="col-md-6">
                            <input type='text' name='nomAssociation' id='nomAssociation' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='nomGroupe' class="col-md-6 control-label">Groupe</label>
                        <div class="col-md-6">
                            <input type='text' name='nomGroupe' id='nomGroupe' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='trancheAge' class="col-md-6 control-label">Tranche d'âge</label>
                        <div class="col-md-6">
                            <input type='text' name='trancheAge' id='trancheAge' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='dateDebutSejour' class="col-md-6 control-label">Début du séjour</label>
                        <div class="col-md-6">
                            <input type='text' name='dateDebutSejour' id='dateDebutSejour' value='<?= $dateDeb->format('d/m/Y') ?>' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='dateFinSejour' class="col-md-6 control-label">Fin du séjour</label>
                        <div class="col-md-6">
                            <input type='text' name='dateFinSejour' id='dateFinSejour' value='<?= $dateFin->format('d/m/Y') ?>' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='nomContact' class="col-md-6 control-label">Votre nom</label>
                        <div class="col-md-6">
                            <input type='text' name='nomContact' id='nomContact' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='mailContact' class="col-md-6 control-label">Votre mail</label>
                        <div class="col-md-6">
                            <input type='text' name='mailContact' id='mailContact' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='telephoneContact' class="col-md-6 control-label">Votre téléphone</label>
                        <div class="col-md-6">
                            <input type='text' name='telephoneContact' id='telephoneContact' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='terrainSouhaite' class="col-md-6 control-label">Terrain idéalement souhaité</label>
                        <div class="col-md-6">
                            <input type='text' name='terrainSouhaite' id='terrainSouhaite' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='nombrePersonnes' class="col-md-6 control-label">Nombre estimé de personnes <em>(enfants et adultes)</em></label>
                        <div class="col-md-6">
                            <input type='text' name='nombrePersonnes' id='nombrePersonnes' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for='nombreTentes' class="col-md-6 control-label">Nombre estimé de tentes</label>
                        <div class="col-md-6">
                            <input type='text' name='nombreTentes' id='nombreTentes' class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-6">
                            <input type='submit' name='envoiMail' value='Envoyer' class="btn submit" />
                        </div>
                    </div>
                </form>
            </fieldset>
            <?php
        }
        // Formulaire de réservation
        if (isset($_GET['envoiMail'])) {
            // Corps du mail
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

            // Headers
            $headers = '';
            // Nettoyage & vérification de l'adresse mail
            $email = filter_var($_GET['mailContact'], FILTER_VALIDATE_EMAIL);
            if ($email != FALSE) {
                $headers = "Reply-To: " . $email;
            }

            mail(__MAIL_GESTIONNAIRE__, utf8_decode('Demande de réservation de Praléron'), utf8_decode($corps), $headers);
            echo "Votre demande a bien été envoyée, nous vous en remercions.<br />L'équipe Praléron.";
        }
        ?>
    </body>
</html>
