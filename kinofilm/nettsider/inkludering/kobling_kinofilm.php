<?php
$tjener = "localhost";
$brukernavn = "root";
$passord = "";
$database = "kinofilm";

$kobling = new mysqli($tjener, $brukernavn, $passord, $database);

if ($kobling->connect_error) {
    die("Noe gikk galt." . $kobling->connect_error);
}

$kobling->set_charset("utf8");
?>