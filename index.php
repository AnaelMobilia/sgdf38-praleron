<?php
/**
 * Copyright 2017-2023 - Anael Mobilia
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' href='https://www.sgdf38.fr/css/styles.css'>
    <style>
        iframe {
            width: 100%;
            min-height: 500px;
        }

        html {
            width: 99%;
        }

        fieldset input[type="tel"], input[type="date"], input[type="email"], input[type="number"], select {
            margin-left: 10px;
        }
    </style>
</head>
<body>
Cliquez sur un terrain pour obtenir ses caractéristiques et des photos.
<br/>
<br/>
<iframe src="https://www.google.com/maps/d/embed?mid=11LLfJuTQQ8zbx_HFWDCfFZ0LHrs"></iframe>
<br/>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" class="form-inline"
      onsubmit="if(document.getElementById('dateFin').value < document.getElementById('dateDeb').value){alert('La date de fin doit être postérieure à la date de début !');return false;}">
    <fieldset>
        Les dates de mon camp sont du &nbsp;
        <input type="date" name="dateDeb" id="dateDeb"
               value="<?= isset($_GET["dateDeb"]) ? $_GET["dateDeb"] : date("Y-m-d") ?>" min="<?= date("Y-m-d") ?>"
               max="<?= date("Y-m-d", time() + 365 * 24 * 60 * 60) ?>"
               onchange="if(document.getElementById('dateFin').value < this.value){let maDate = new Date(this.value);maDate.setDate(maDate.getDate() + 1);document.getElementById('dateFin').value = maDate.toISOString().slice(0, 10)}"/>
        &nbsp;au&nbsp;
        <input type="date" name="dateFin" id="dateFin"
               value="<?= isset($_GET["dateFin"]) ? $_GET["dateFin"] : date("Y-m-d", time() + 24 * 60 * 60) ?>"
               min="<?= date("Y-m-d") ?>" max="<?= date("Y-m-d", time() + 365 * 24 * 60 * 60) ?>"/>
        <input name="submit" type="submit" value="Voir les terrains disponibles" class="btn submit"/>
    </fieldset>
</form>
<?php
// Formulaire de disponibilités
if (isset($_GET['submit'])) {
    $dateDeb = new DateTime($_GET['dateDeb']);
    $dateFin = new DateTime($_GET['dateFin']);
    $result = getTerrainDispo($dateDeb, $dateFin);
    $nbResult = count($result);
    ?>
    <fieldset>
        <?php if ($nbResult == 0) : ?>
            Désolé, aucun terrain n'est disponible à ces dates !
            <br/>
            <!--N'hésitez pas à nous contacter quand même via le formulaire pour que nous voyons ce que nous pouvons faire pour votre séjour !-->
            N'hésitez pas à revenir voir ultérieurement si une place s'est libérée !
        <?php else : ?>
            <legend>
                Terrain<?= ($nbResult > 1 ? "s" : "") ?> disponible<?= ($nbResult > 1 ? "s" : "") ?> à ces dates :
            </legend>
            <ul>
                <?php foreach ($result as $unTerrain) : ?>
                    <li><?= $unTerrain ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </fieldset>
    <?php if ($nbResult >= 1) : ?>
        <fieldset>
            <legend>Effectuer une demande de réservation :</legend>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="form-horizontal">
                <div class="form-group">
                    <label for='Association' class="col-md-6 control-label">Association</label>
                    <div class="col-md-6">
                        <input type='text' name='Association' id='Association' class="form-control" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for='Groupe' class="col-md-6 control-label">Groupe</label>
                    <div class="col-md-6">
                        <input type='text' name='Groupe' id='Groupe' class="form-control" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for='TrancheDAge' class="col-md-6 control-label">Tranche d'âge</label>
                    <div class="col-md-6">
                        <input type='text' name='TrancheDAge' id='TrancheDAge' class="form-control" required/>
                    </div>
                </div>
                <!-- Gestion des dates de réservation -->
                <input type='hidden' name='DebutDuSejour' id='DebutDuSejour' value='<?= $dateDeb->format('d/m/Y') ?>'
                       class="invisible"/>
                <input type='hidden' name='FinDuSejour' id='FinDuSejour' value='<?= $dateFin->format('d/m/Y') ?>'
                       class="invisible"/>
                <!-- Fin dates de réservation -->
                <div class="form-group">
                    <label for='Contact' class="col-md-6 control-label">Votre nom</label>
                    <div class="col-md-6">
                        <input type='text' name='Contact' id='Contact' class="form-control" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for='AdresseMail' class="col-md-6 control-label">Votre mail</label>
                    <div class="col-md-6">
                        <input type='email' name='AdresseMail' id='AdresseMail' class="form-control" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for='Telephone' class="col-md-6 control-label">Votre téléphone</label>
                    <div class="col-md-6">
                        <input type='tel' name='Telephone' id='Telephone' class="form-control" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for='TerrainSouhaite' class="col-md-6 control-label">Terrain idéalement souhaité</label>
                    <div class="col-md-6">
                        <select name='TerrainSouhaite[]' id='TerrainSouhaite' class="form-control" multiple required>
                            <option selected="selected" disabled="disabled" value="">--- Choisir ---</option>
                            <?php foreach ($result as $unTerrain) : ?>
                                <option value="<?= $unTerrain ?>"><?= $unTerrain ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for='NombreDePersonnes' class="col-md-6 control-label">Nombre estimé de personnes <em>(enfants
                            et
                            adultes)</em></label>
                    <div class="col-md-6">
                        <input type='number' name='NombreDePersonnes' id='NombreDePersonnes' class="form-control"
                               required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for='NombreDeTentes' class="col-md-6 control-label">Nombre estimé de tentes</label>
                    <div class="col-md-6">
                        <input type='number' name='NombreDeTentes' id='NombreDeTentes' class="form-control" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        <input type='submit' name='envoiMail' value='Envoyer' class="btn submit"/>
                    </div>
                </div>
            </form>
        </fieldset>
    <?php
    endif;
}
// Formulaire de réservation
if (isset($_POST['envoiMail'])) {
    // Corps du mail
    $corps = 'Une nouvelle demande de réservation a été formulée via le site :' . "\r\n";
    foreach ($_POST as $key => $value) {
        // On ne prend pas la balise d'envoi du mail ... ;)
        if ($key != 'envoiMail') {
            // On ajoute des espaces dans le nom de la clef + formatage visuel
            $clefEspace = trim(strtolower(preg_replace('#([A-Z])#', ' $0', $key)));
            $corps .= ucfirst($clefEspace);
            // Séparateur...
            $corps .= ' : ';
            // La valeur
            if (is_array($value)) {
                // array -> str
                $value = implode(" + ", $value);
            }
            $corps .= $value . "\r\n";
        }
    }

    // Headers
    $headers = '';
    // Nettoyage & vérification de l'adresse mail
    $email = filter_var($_POST['AdresseMail'], FILTER_VALIDATE_EMAIL);
    if ($email != FALSE) {
        $headers = "Reply-To: " . $email;
    }

    mail(__MAIL_GESTIONNAIRE__, utf8_decode('Demande de réservation de Praléron'), utf8_decode($corps), $headers);
    echo "Votre demande a bien été envoyée, nous vous en remercions.<br />L'équipe Praléron.";
}
?>
</body>
</html>
