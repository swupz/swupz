<?php include "../inkludering/session.php"; ?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title><?php $_GET["film_id"]; ?></title>
    <link href="../inkludering/spesifikk_film&kvittering_stilark.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php
include "../inkludering/kobling_kinofilm.php";
include "../inkludering/meny.php";

if (isset($_GET["film_id"])) {
    $film_id = $_GET["film_id"];
    $fstilling_id = $_GET["forestillings_id"];

    $filmstilling_sql = "SELECT * FROM film JOIN forestilling ON film.film_id=forestilling.film_id WHERE fstilling_id='$fstilling_id' ORDER BY tidspunkt ASC";
    $filmstilling_sprng = $kobling->query($filmstilling_sql);
    $filmstilling = $filmstilling_sprng->fetch_assoc();
        $tittel = $filmstilling["tittel"];
        $utgar = $filmstilling["utgivelsesar"];
        $beskrivelse = $filmstilling["beskrivelse"];
        $ogsprak = $filmstilling["ogsprak"];
        $sjanger = $filmstilling["sjanger"];
        $regissor_id = $filmstilling["regissor_id"];
        $salnv = $filmstilling["salnv"];
        $tidspunkt = strtotime($filmstilling["tidspunkt"]);

    $tidvisning = date("H:i d-m", "$tidspunkt");

    $sal_sql = "SELECT seteantall, pris FROM sal WHERE salnv='$salnv'";
    $sal_sprng = $kobling->query($sal_sql);
    $sal = $sal_sprng->fetch_assoc();
        $maxsete = $sal["seteantall"];
        $pris = $sal["pris"];

    $billett_sql = "SELECT sum(seter_kjopt) FROM billett WHERE fstilling_id='$fstilling_id'";
    $billett_sprng = $kobling->query($billett_sql);
    $billett = $billett_sprng->fetch_assoc();
    $seter_kjopt = $billett["sum(seter_kjopt)"];

    $ledige_seter = $maxsete - $seter_kjopt;

    $regissor_sql = "SELECT * FROM regissor WHERE regissor_id='$regissor_id'";
    $regissor_sprng = $kobling->query($regissor_sql);
    $regissor = $regissor_sprng->fetch_assoc();
        $regfnv = $regissor["regfnv"];
        $regenv = $regissor["regenv"];

    $bilde_sql = "SELECT bilde_kobling FROM bilde WHERE film_id='$film_id'";
    $bilde_sprng = $kobling->query($bilde_sql);
    $bilde = $bilde_sprng->fetch_assoc();
        $bilde_kobling = $bilde["bilde_kobling"];

    $pris_sql = "SELECT pris FROM sal WHERE salnv='$salnv'";
    $pris_sprng = $kobling->query($pris_sql);
    $pris_array = $pris_sprng->fetch_assoc();

    $pris = $pris_array["pris"];

    echo "<div id='pakkinn_alt'>";
        echo "<figure id='bilde'><img src='$bilde_kobling' alt='Posteren til $tittel'></figure>";

        echo "<div id='pakkinn'>";

        echo "<div id='tittel'>$tittel</div><div id='linjebreak'></div>";

        echo "<div id='tid'>Vises i sal $salnv, $tidvisning</div>";

        echo "<div id='billett'>Kjøp billetter: ($pris kr per billett)";

            echo "<form method='post' action='kvittering.php'>";
            echo "<input name='antall_seter' type='number' max='$ledige_seter' min='1' value='1'>";
            echo "<input name='tittel' type='hidden' value='$tittel'>";
            echo "<input name='tidvisning' type='hidden' value='$tidvisning'>";
            echo "<input name='salnv' type='hidden' value='$salnv'>";
            echo "<input name='pris' type='hidden' value='$pris'>";
            echo "<input name='fstilling_id' type='hidden' value='$fstilling_id'>";
            echo "<input type='submit' name='kjop' value='Kjøp'>";
            echo "</form>";

            echo "<div id='pris'></div>";
        echo "</div>";

        echo "<div id='sjanger'>$sjanger | $utgar | $ogsprak</div>";

        echo "<div id='utgar'></div>";

        echo "<div id='sprak'></div>";


        echo "<div id='reg'>Regissøren bak filmen: $regfnv $regenv</div>";

        echo "<div id='sal'></div>";

        echo "<div id='bskr'>Sammendrag: <br> $beskrivelse</div>";
    echo "</div>";
    echo "</div>";
}
?>
</body>
</html>