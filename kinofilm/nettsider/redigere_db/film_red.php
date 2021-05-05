<?php include "../inkludering/session.php"; ?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Rediger/Legg til film</title>
    <link href="../inkludering/redigering_stilark.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include "../inkludering/kobling_kinofilm.php";
include "../inkludering/meny.php";
?>
<div class="innpak">
    <div class="leggtil">
        <form method="post">
            <table>
                <tr>
                    <td><label for="tittel">Tittel</label></td>
                    <td><input name="tittel" type="text"></td>
                </tr>
                <tr>
                    <td><label for="utgar">Utgivelsesår</label></td>
                    <td><input name="utgar" type="number"></td>
                </tr>
                <tr>
                    <td><label for="bskr">Beskrivelse</label></td>
                    <td><textarea name="bskr" rows="5" cols="30"></textarea></td>
                </tr>
                <tr>
                    <td><label for="ogsprak">Originalspråk</label></td>
                    <td><input name="ogsprak" type="text"></td>
                </tr>
                <tr>
                    <td><label for="sjanger">Sjanger</label></td>
                    <td><input name="sjanger" type="text"></td>
                </tr>
                <tr>
                    <td><p>Regissør</p></td>
                    <td><?php
                        $sql = "SELECT * FROM regissor";
                        $resultat = $kobling->query($sql);

                        echo "<select name='reg_id'>";
                        while ($rad = $resultat->fetch_assoc()) {
                            $regid = $rad["regissor_id"];
                            $regfnv = $rad["regfnv"];
                            $regenv = $rad["regenv"];

                            echo "<option value=$regid>$regfnv $regenv</option>";
                        }
                        echo "</select>";
                        ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input name="leggtil" type="submit" value="Legg til"></td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST["leggtil"])) {
            $tittel = $_POST["tittel"];
            $utgar = $_POST["utgar"];
            $bskr = $_POST["bskr"];
            $ogsprak = $_POST["ogsprak"];
            $sjanger = $_POST["sjanger"];
            $reg_id = $_POST["reg_id"];

            $check = "SELECT film_id, tittel, utgivelsesar FROM film";
            $resultat = $kobling->query($check);

            while ($rad = $resultat->fetch_assoc()) {
                $check_tittel = $rad["tittel"];
                $check_utgar = $rad["utgivelsesar"];
                $film_id = $rad["film_id"];

                if ($check_tittel == $tittel && $check_utgar == $utgar) {
                    die ("<p>Du har lagt inn en film som allerede eksisterer i databasen.</p><meta http-equiv='refresh' content='2;URL=film_red.php'>");
                }
            }

            if (!isset($film_id)) {
                $bilde_filmid = 1;
            } else {
                $bilde_filmid = $film_id + 1;
            }

            $sql = "INSERT INTO film (tittel, utgivelsesar, beskrivelse, ogsprak, sjanger, regissor_id) VALUES ('$tittel', '$utgar', '$bskr', '$ogsprak', '$sjanger', '$reg_id')";
            $bilde_sql = "INSERT INTO bilde (bilde_kobling, film_id) VALUES ('../../bilder/$tittel', '$bilde_filmid')";

            if ($kobling->query($sql)) {
                $kobling->query($bilde_sql);
                echo "<p>Filmen ble lagt til.</p>";
            } else {
                die ("<p>Det gikk noe galt.</p>");
            }
        }
        ?>
    </div>
    <br>
    <div class="endre">
        <?php
        $filmene = "SELECT * FROM regissor JOIN film ON regissor.regissor_id=film.regissor_id";
        $filmene_hentet = $kobling->query($filmene);

        echo "<table>";
        echo "<tr>";
        echo "<th>Tittel</th>";
        echo "<th>Utgivelsesår</th>";
        echo "<th>Sjanger</th>";
        echo "<th>Regissør</th>";
        echo "<th>Endre</th>";
        echo "</tr>";
        while ($rad = $filmene_hentet->fetch_assoc()) {
            $op_filmid = $rad["film_id"];
            $op_tittel = $rad["tittel"];
            $op_utgar = $rad["utgivelsesar"];
            $op_sjanger = $rad["sjanger"];
            $op_regfnv = $rad["regfnv"];
            $op_regenv = $rad["regenv"];

            echo "<tr>";
            echo "<form method='post'>";
            echo "<td>$op_tittel</td> <td>$op_utgar</td> <td>$op_sjanger</td> <td>$op_regfnv $op_regenv</td> ";
            echo "<input type='hidden' name='endre_id' value='$op_filmid'>";
            echo "<td><input type='submit' name='endre' value='Endre'></td>";
            echo "</tr></form>";
        }
        echo "</table>";

        if (isset($_POST["endre_id"])) {
            $endre_id = $_POST["endre_id"];

            $valgtfilm = "SELECT * FROM regissor JOIN film ON regissor.regissor_id=film.regissor_id WHERE film_id='$endre_id'";
            $valgtfilm_sporring = $kobling->query($valgtfilm);
            $valgtfilm_hentet = $valgtfilm_sporring->fetch_assoc();

            $valgttittel = $valgtfilm_hentet["tittel"];
            $valgtutgar = $valgtfilm_hentet["utgivelsesar"];
            $valgtbskr = $valgtfilm_hentet["beskrivelse"];
            $valgtogsprak = $valgtfilm_hentet["ogsprak"];
            $valgtsjanger = $valgtfilm_hentet["sjanger"];
            $valgtregid = $valgtfilm_hentet["regissor_id"];

            $forelopig_regfnv = $valgtfilm_hentet["regfnv"];
            $forelopig_regenv = $valgtfilm_hentet["regenv"];

            echo "<form method='post'>";

            echo "<input type='hidden' name='opd_id' value='$endre_id'>";
            echo "<input type='text' name='nytt_tittel' value='$valgttittel'>";
            echo "<input type='hidden' name='check_nytittel' value='$valgttittel'>";
            echo "<input type='number' name='nytt_utgar' value='$valgtutgar'>";
            echo "<textarea name='nytt_bskr'>$valgtbskr</textarea>";
            echo "<input type='text' name='nytt_ogsprak' value='$valgtogsprak'>";
            echo "<input type='text' name='nytt_sjanger' value='$valgtsjanger'>";

            $hentreg = "SELECT * FROM regissor";
            $reg_meny = $kobling->query($hentreg);

            echo "<p>Foreløpig regissør: </p>$forelopig_regfnv $forelopig_regenv ";
            echo "<select name='reg_id'>";
            while ($rad = $reg_meny->fetch_assoc()) {
                $regid = $rad["regissor_id"];
                $regfnv = $rad["regfnv"];
                $regenv = $rad["regenv"];

                echo "<option value=$regid>$regfnv $regenv</option>";
            }
            echo "</select>";

            echo "<input type='submit' name='opd' value='Oppdater'>";
            echo "</form>";
        }

        if (isset($_POST["opd_id"])) {
            $opd_id = $_POST["opd_id"];
            $nytttittel = $_POST["nytt_tittel"];
            $nyttutgar = $_POST["nytt_utgar"];
            $nyttbskr = $_POST["nytt_bskr"];
            $nyttogsprak = $_POST["nytt_ogsprak"];
            $nyttsjanger = $_POST["nytt_sjanger"];
            $nyttreg = $_POST["reg_id"];
            $check_nytittel = $_POST["check_nytittel"];


            $oppdatering = "UPDATE film SET tittel='$nytttittel', utgivelsesar='$nyttutgar', beskrivelse='$nyttbskr', ogsprak='$nyttogsprak', sjanger='$nyttsjanger', regissor_id='$nyttreg' WHERE film_id='$opd_id'";

            if ($nytttittel != $check_nytittel) {
                $endre_bilde_sql = "UPDATE bilde SET (bilde_kobling='../../bilder/$nytttittel') WHERE film_id='$opd_id'";
                $kobling->query($endre_bilde_sql);
            }

            if ($kobling->query($oppdatering)) {
                echo "<p>Filmen har blitt oppdatert.</p><meta http-equiv='refresh' content='2;URL=film_red.php'>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>