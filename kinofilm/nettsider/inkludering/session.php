<?php
include "../inkludering/kobling_kinofilm.php";
session_start();

$user_check = $_SESSION['brukernavn'];

$session_sql = "select bnv from bruker where bnv='$user_check'";
$session_sprng = $kobling->query($session_sql);
$session_row = $session_sprng->fetch_assoc();

$login_session = $session_row['bnv'];

if(!isset($_SESSION['brukernavn'])){
    header("location:../forbruker/innlogging.php");
    die();
}
?>