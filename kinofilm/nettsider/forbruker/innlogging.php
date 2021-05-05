<?php session_start(); ?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Innlogging</title>
    <link href="../inkludering/innlogging_stilark.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php
include "../inkludering/kobling_kinofilm.php";
?>

<div id="login_innpak">
    <div id="hoyre">
        <h3>Logg inn</h3>
        <a href="ny_bruker.php">Ingen bruker?</a>
    </div>

    <div id="venstre">
        <form method="post">
            <table>
                <tr class="brukerpassord">
                    <td><label for="bnv">Brukernavn: </label></td>
                    <td><input type="text" name="bnv"></td>
                </tr>

                <tr class="brukerpassord">
                    <td><label for="passord">Passord: </label>
                    <td><input id="passord_login" type="password" name="passord"></td>
                </tr>

                <tr>
                    <td></td>
                    <td><input id="knapp" type="submit" name="logginn" value="Logg inn"></td>
                </tr>
            </table>
        </form>
    </div>

    <?php
    if (isset($_POST["logginn"])) {
        $bruker = $_POST["bnv"];
        $passord = $_POST["passord"];

        $check_passord = hash("sha256", "$passord");

        $check_sql = "SELECT admin FROM bruker WHERE bnv='$bruker' AND passord='$check_passord'";
        $check_sprng = $kobling->query($check_sql);
        $check = $check_sprng->fetch_assoc();
        $riktig = $check_sprng->num_rows;

        if ($riktig == 1) {
            $admin = $check["admin"];
            $_SESSION["brukernavn"] = $bruker;
            $_SESSION["admin"] = $admin;

            header("location:fremside.php");
            exit();
        } else {
            echo "<p>Brukernavnet eller passordet er feil. Vennligst tast inn på nytt.</p>";
        }
    }
    ?>
    </div>
</body>
</html>