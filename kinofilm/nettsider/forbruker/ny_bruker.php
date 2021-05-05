<?php session_start(); ?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Ny bruker</title>
    <link href="../inkludering/innlogging_stilark.css" type="text/css" rel="stylesheet">
</head>
<body>
<div id="login_innpak">
    <div id="hoyre">
        <form method="post">
            <table>
                <tr class="brukerpassord2">
                    <td><label for="bnv">Brukernavn: </label></td>
                    <td><input type="text" name="bnv" maxlength="20" required></td>
                </tr>
                <tr class="brukerpassord2">
                    <td><label for="passord">Passord: </label></td>
                    <td><input id="passord_nybruker" type="password" name="passord" required></td>
                </tr>
                <tr class="brukerpassord2">
                    <td><label for="fnv">Fornavn: </label></td>
                    <td><input type="text" name="fnv" required></td>
                </tr>
                <tr class="brukerpassord2">
                    <td><label for="env">Etternavn: </label></td>
                    <td><input type="text" name="env" required></td>
                </tr>
                <tr class="brukerpassord2">
                    <td><label for="email">E-mail: </label></td>
                    <td><input type="email" name="email" required></td>
                </tr>
                <tr>
                    <td></td><input type="hidden" name="admin" value="0">
                    <td><input id="knapp" type="submit" name="leggtil" value="Lag bruker"></td>
                </tr>
            </table>
        </form>
    </div>

    <div id="venstre2">
        <h3>Lag bruker</h3>
        <a href="innlogging.php">Har allerede bruker?</a>
    </div>
    <div id="melding">
        <?php
        include "../inkludering/kobling_kinofilm.php";
        if (isset($_POST["leggtil"])) {
            $bnv = $_POST["bnv"];
            $passord = $_POST["passord"];
            $fnv = $_POST["fnv"];
            $env = $_POST["env"];
            $email = $_POST["email"];
            $admin = $_POST["admin"];

            $insert_passord = hash("sha256", "$passord");

            $check_sql = "SELECT * FROM bruker";
            $check_sprng = $kobling->query($check_sql);

            while ($check_row = $check_sprng->fetch_assoc()) {
                $check_bnv = $check_row["bnv"];
                $check_email = $check_row["email"];

                if ($check_bnv == $bnv) {
                    if ($check_email == $email) {
                        die ("<p>Både brukernavnet og emailen er i bruk.</p>");
                    } else {
                        die ("<p>Brukernavnet er alle tatt bruk</p>");
                    }
                } else if ($check_email == $email) {
                    die ("<p>Emailen din er allerede tatt i bruk</p>");
                }
            }

            $leggtil_sql = "INSERT INTO bruker (bnv, fnv, env, email, passord, admin) VALUES ('$bnv', '$fnv', '$env', '$email', '$insert_passord', '$admin')";

            if ($kobling->query($leggtil_sql)) {
                $_SESSION["bruker"] = $bnv;
                $_SESSION["admin"] = $admin;
                echo "<a href='fremside.php'>Brukeren din har blitt lagt til. Trykk for å komme videre til framsiden.</a>";
            } else {
                exit("<p>Brukeren ble ikke laget, prøv på nytt.</p>");
            }
        }

        ?>
    </div>
</div>
</body>
</html>