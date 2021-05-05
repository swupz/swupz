<?php include "../inkludering/session.php"; ?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Fremside</title>
    <link href="../inkludering/fremside_stilark.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php
include "../inkludering/kobling_kinofilm.php";
include "../inkludering/meny.php";
?>

<?php
$filmplan_sql = "SELECT * FROM forestilling ORDER BY tidspunkt DESC";
$filmplan_sprng = $kobling->query($filmplan_sql);
$filmplan = $filmplan_sprng->fetch_assoc();

if (isset($filmplan["tidspunkt"])) {
    $siste_forestilling = $filmplan["tidspunkt"];
    $sist_tid = strtotime("$siste_forestilling");
} else {
    $dato_sist_tid = date("Y-m-d-H");
    $sist_tid = strtotime("$dato_sist_tid");
}

$idag = date("Y-m-d-H");
$ny_tid = strtotime("+7 days, $idag");
$ny_tid_check = strtotime("+6 days, $idag");

if ($ny_tid_check > $sist_tid) {
    $forestilling_per_dag = 4;
    $antall_dager = floor(($ny_tid - $sist_tid) / 3600 / 24)+1;
    if ($antall_dager == 0) {
        $antall_dager = 7;
    }

    $saler_sql = "SELECT salnv FROM sal";
    $saler_sprng = $kobling->query($saler_sql);
    $antall_saler = mysqli_num_rows($saler_sprng);

    $filmer_sql = "SELECT film_id FROM film";
    $filmer_sprng = $kobling->query($filmer_sql);
    $antall_filmer = mysqli_num_rows($filmer_sprng);

    $neste_dag = 0;

    for ($i = 1; $i <= $antall_dager;) {
        $ar = date("Y", $sist_tid + $neste_dag);
        $maned = date("m", $sist_tid + $neste_dag);
        $dag = date("d", $sist_tid + $neste_dag);

        for ($y = 0; $y < $forestilling_per_dag;) {
            $time = rand(14, 22);
            $valgt_sal = rand(1, $antall_saler);
            $valgt_film = rand(1, $antall_filmer);

            $mkt_tidspunkt = mktime("$time", "00", "00", "$maned", "$dag", "$ar");
            $valgt_tidspunkt = date("Y-m-d H:i:s", "$mkt_tidspunkt");

            $ny_forestilling = "INSERT INTO forestilling (salnv, tidspunkt, film_id) VALUES ('$valgt_sal', '$valgt_tidspunkt', '$valgt_film')";
            $kobling->query($ny_forestilling);

            $y++;
        }

        $neste_dag = 3600 * 24 * $i;
        $i++;
    }
}
?>
<div id="innpak">
    <div id="undertittel"><h2>Filmer på kino den neste uken</h2></div>


    <?php
    $filmstillinger_sql = "SELECT * FROM film JOIN forestilling ON film.film_id=forestilling.film_id ORDER BY tidspunkt ASC";
    $filmstilling_sprng = $kobling->query($filmstillinger_sql);

    while ($filmstillinger = $filmstilling_sprng->fetch_assoc()) {
        $f_id = $filmstillinger["film_id"];
        $f_tittel = $filmstillinger["tittel"];
        $f_ogspr = $filmstillinger["ogsprak"];
        $f_sjang = $filmstillinger["sjanger"];
        $f_utgar = $filmstillinger["utgivelsesar"];
        $fore_id = $filmstillinger["fstilling_id"];
        $tidspunkt = $filmstillinger["tidspunkt"];

        if ($tidspunkt >= $idag) {
            $poster_sql = "SELECT bilde_kobling FROM bilde WHERE film_id='$f_id'";
            $poster_sprng = $kobling->query($poster_sql);
            $poster = $poster_sprng->fetch_object();

            $tidimangesifre = strtotime($tidspunkt);
            $dagtime = date("d.m H:i", "$tidimangesifre");

            echo "<div class='filmboks'>";
            echo "<img class='poster' src='$poster->bilde_kobling' alt='Posteren til $f_tittel'>";

            echo "<div class='info'>";

            echo "<div class='tittel'>$f_tittel</div><br>";
            echo "<div class='spranger'>$f_sjang | $f_ogspr</div>";
            echo "<div class='tid'>$dagtime</div><br>";
            echo "<a href='spesifikk_film.php?film_id=$f_id&forestillings_id=$fore_id'><div class='bestill'>Bestill billetter</div></a>";

            echo "</div>";

            echo "</div>";
        }
    }
    ?>
</div>
</body>
</html>