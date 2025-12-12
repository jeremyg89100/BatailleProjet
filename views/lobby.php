<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <title>Choix du rôle</title>
    <link rel="stylesheet" href="lobby.css">
</head>

<body>
    <h1>Connexion aux rôles</h1>
    <h2>Votre rôle actuel : <span><?php if ($etat["j1"] !== null): ?>
            <span style="color: yellow;"><?php echo "<br> $role <br>"; ?></span>
            <?php elseif($etat["j2"] !== null): ?>
            <span style="color: cyan;"><?php echo "<br> $role </br>"; ?></span>
            <?php else: ?>
            <span style="background: linear-gradient(120deg, yellow 30%, cyan 70%);
                        background-clip: text;
                        color: transparent;">
                <?php echo "<br> Aucun roles <br>"; ?></span>
            <?php endif; ?>
        </span>
    </h2>
    <p class="p1">
        Joueur 1 : <?= $etat["j1"] ? "🟢 Occupé" : "🔴 Libre" ?><br>
    </p>
    <p class="p2">
        Joueur 2 : <?= $etat["j2"] ? "🟢 Occupé" : "🔴 Libre" ?>
    </p>

    <form method="post">
        <button type="submit" name="joueur1" value="joueur1" class="button1"
            <?= ($etat["j1"] !== null || $etat["j2"] === session_id()) ? "disabled" : "" ?>>
            🎮 Devenir Joueur 1
        </button>
        <button type="submit" name="joueur2" value="joueur2" class="button2"
            <?= ($etat["j2"] !== null || $etat["j1"] === session_id()) ? "disabled" : "" ?>>
            🎮 Devenir Joueur 2
        </button>
    </form>
    <form action="/bataille/scripts/reset_total.php" method="post">
        <button type="submit" name="reset_total" class="reset">
            ❌ Fin de partie (RESET)
        </button>
    </form>
</body>

</html>