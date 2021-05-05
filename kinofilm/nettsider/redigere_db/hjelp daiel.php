<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
include "../inkludering/kobling_kinofilm.php";
$sql = "SELECT * FROM film";
$resultat = $kobling->query($sql);
while($rad = $resultat->fetch_assoc()) {
    $radsadboi hours
}
?>
</body>
</html>