<?php include "../inkludering/session.php"; ?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title><?php $_POST["tittel"]; ?></title>
    <link href="../inkludering/spesifikk_film&kvittering_stilark.css" type="text/css" rel="stylesheet">
</head>
<body>
<div id="kvittering_body">
    <?php
    include "../inkludering/kobling_kinofilm.php";
    include "../inkludering/meny.php";

    if (isset($_POST["kjop"])) {
        $tittel = $_POST["tittel"];
        $tidvisning = $_POST["tidvisning"];
        $antall_seter = $_POST["antall_seter"];
        $salnv = $_POST["salnv"];
        $fstilling_id = $_POST["fstilling_id"];
        $pris = $_POST["pris"];

        $pris_total = $pris * $antall_seter;

        echo "<p id='tittel'>$tittel</p>";
        echo "<p>Pris å betale: $pris_total kr</p>";
        echo "<p>Når den blir vist: $tidvisning</p>";
        echo "<p>Antall seter: $antall_seter</p>";
        echo "<p>Sal $salnv</p>";
    }

    if (isset($_POST["sendinn"])) {
        $seksten = $_POST["seksten"];
        $dato1 = $_POST["dato"];
        $dato2 = $_POST["dato2"];
        $tre = $_POST["tre"];
        $bnv = $_SESSION["brukernavn"];
        $tittel = $_POST["tittel"];
        $tidvisning = $_POST["tidvisning"];
        $antall_seter = $_POST["antall_seter"];
        $salnv = $_POST["salnv"];
        $fstilling_id = $_POST["fstilling_id"];
        $pris_total = $_POST["pris_total"];

        echo "<p>$tittel</p>";
        echo "<p>Pris å betale: $pris_total</p>";
        echo "<p>Når den blir vist: $tidvisning</p>";
        echo "<p>Antall seter: $antall_seter</p>";
        echo "<p>Sal $salnv</p>";

        if (15 < log10($seksten) && log10($seksten) < 16 && 0 < $dato1 && $dato1 < 13 && 19 < $dato2 && $dato2 < 100 && 0 < $tre && $tre < 1000) {
            $billett_sql = "INSERT INTO billett (bnv, fstilling_id, seter_kjopt) VALUES ('$bnv', '$fstilling_id', '$antall_seter')";
            if ($kobling->query($billett_sql)) {
                echo "<p>Betaling gjennomført. Billetten sendes på e-mail. Du blir automatisk sendt tilbake til fremsiden.</p>";
                echo "<meta http-equiv='refresh' content='3;URL=fremside.php'>";
            } else {
                echo "det fungete ikkje";
            }
        } else {
            echo "<p id='feilmelding'>Kortinformasjonen inntastet virker å være feil. Kanskje, muligens du kunne ønsket å skrive inn på ny, vær så snill.</p>";
        }
    }
    ?>

    <form method="post">
        <?php
        echo "<input type='hidden' name='fstilling_id' value='$fstilling_id'>";
        echo "<input type='hidden' name='antall_seter' value='$antall_seter'>";
        echo "<input type='hidden' name='tittel' value='$tittel'>";
        echo "<input type='hidden' name='tidvisning' value='$tidvisning'>";
        echo "<input type='hidden' name='salnv' value='$salnv'>";
        echo "<input type='hidden' name='pris_total' value='$pris_total'>";
        ?>
        <table id="kortkjop">
            <tr>
                <td><label for="seksten">Kortnummer:</label></td>
                <td><input type="number" name="seksten"></td>
            </tr>

            <tr>
                <td><label for="dato">Dato:</label></td>
                <td>
                    <input type="number" name="dato">
                    <p id="kortinfo">/</p>
                    <input type="number" name="dato2">
                </td>
            </tr>

            <tr>
                <td><label for="tre">Sikkerhetskode:</label></td>
                <td><input type="number" name="tre"></td>
            </tr>
        </table><br>

        <input type="submit" name="sendinn" value="Betal">
    </form>
</div>
</body>
</html>