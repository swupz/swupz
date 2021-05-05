<?php include "../inkludering/session.php"; ?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Rediger/Legg til regissør</title>
    <link href="../inkludering/redigering_stilark.css" type="text/css" rel="stylesheet">
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
                    <td><label for="regfnv">Fornavn</label></td>
                    <td><input name="regfnv" type="text"></td>
                </tr>
                <tr>
                    <td><label for="regenv">Etternavn</label></td>
                    <td><input name="regenv" type="text"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input name="leggtil" type="submit" value="Legg til"></td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST["leggtil"])) {
            $lt_regfnv = $_POST["regfnv"];
            $lt_regenv = $_POST["regenv"];

            $check = "SELECT * FROM regissor";
            $resultat = $kobling->query($check);

            while ($rad = $resultat->fetch_assoc()) {
                $check_regfnv = $rad["regfnv"];
                $check_regenv = $rad["regenv"];

                if ($check_regfnv == $lt_regfnv && $check_regenv == $lt_regenv) {
                    die ("<p>Du har lagt inn en regissør som allerede eksisterer i databasen.</p><meta http-equiv='refresh' content='2;URL=regissor_red.php'>");
                }
            }

            $sql = "INSERT INTO regissor (regfnv, regenv) VALUES ('$lt_regfnv', '$lt_regenv')";

            if ($kobling->query($sql)) {
                echo "<p>Regissøren ble lagt til.</p>";
            } else {
                die ("<p>Det gikk noe galt.");
            }
        }
        ?>
    </div>
    <br>
    <div class="endre">
        <?php
        $regissorene = "SELECT * FROM regissor";
        $regissorene_hentet = $kobling->query($regissorene);

        echo "<table id='reg'><tr><th>Fornavn</th><th>Etternavn</th><th>Endre</th></tr>";
        while ($rad = $regissorene_hentet->fetch_assoc()) {
            $op_regid = $rad["regissor_id"];
            $op_regfnv = $rad["regfnv"];
            $op_regenv = $rad["regenv"];

            echo "<tr>";
            echo "<form method='post'>";
            echo "<td>$op_regfnv</td> <td>$op_regenv</td>";
            echo "<input type='hidden' name='endre_id' value='$op_regid'>";
            echo "<td><input type='submit' name='endre' value='Endre'></td>";
            echo "</form>";
            echo "</tr>";
        }
        echo "</table>";

        if (isset($_POST["endre_id"])) {
            $endre_id = $_POST["endre_id"];
            $valgtreg = "SELECT * FROM regissor WHERE regissor_id='$endre_id'";
            $valgtreg_sporring = $kobling->query($valgtreg);
            $valgtreg_hentet = $valgtreg_sporring->fetch_assoc();

            $valgtregfnv = $valgtreg_hentet["regfnv"];
            $valgtregenv = $valgtreg_hentet["regenv"];

            echo "<form method='post'>";
            echo "<input type='hidden' name='opd_id' value='$endre_id'>";
            echo "<p>Fornavn </p><input type='text' name='nytt_regfnv' value='$valgtregfnv'>";
            echo "<p> Etternavn </p><input type='text' name='nytt_regenv' value='$valgtregenv'>";
            echo "<input type='submit' name='opd' value='Oppdater'>";
            echo "</form>";
        }

        if (isset($_POST["opd_id"])) {
            $opd_id = $_POST["opd_id"];
            $nyttregfnv = $_POST["nytt_regfnv"];
            $nyttregenv = $_POST["nytt_regenv"];

            $oppdatering = "UPDATE regissor SET regfnv='$nyttregfnv', regenv='$nyttregenv' WHERE regissor_id='$opd_id'";

            if ($kobling->query($oppdatering)) {
                echo "<p>Navnet til regissøren er oppdatert til $nyttregfnv $nyttregenv.</p>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>