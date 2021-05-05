<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<div id="meny">
    <div id="midtstill">
        <a href="../forbruker/fremside.php"><div id="hovedtittel">
            <img src="../../bilder/fremside_tittel.png"
                                                     alt="filmkamera clipart">
            <h1>Kinofilm</h1>
        </div></a>

        <div id="meny_innhold">
            <?php
            if ($_SESSION["admin"] == 1) {
                echo "<a class='meny_link' href='../redigere_db/meny_red.php'><div class='meny_valg'>Rediger databasen</div></a>";
            }
            ?>
            <a class="meny_link" href='../inkludering/utlogging.php'>
                <div class="meny_valg">Logg ut</div>
            </a>
        </div>
    </div>
</div>
</body>
</html>