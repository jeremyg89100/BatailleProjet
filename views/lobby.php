<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix du rôle</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Connexion aux rôles</h1>
    <h2>Votre rôle actuel : <strong><?= htmlspecialchars($role) ?></strong></h2>

    <p>Joueur 1 : <?= $etat['j1'] ? '🟢 Occupé' : '🔴 Libre' ?><br>
       Joueur 2 : <?= $etat['j2'] ? '🟢 Occupé' : '🔴 Libre' ?></p>

    <form method="post">
        <button type="submit" name="joueur1" value="joueur1"
            <?= ($etat['j1'] !== null || $etat['j2'] === session_id()) ? 'disabled' : '' ?>>
            🎮 Devenir Joueur 1
        </button>
        <button type="submit" name="joueur2" value="joueur2"
            <?= ($etat['j2'] !== null || $etat['j1'] === session_id()) ? 'disabled' : '' ?>>
            🎮 Devenir Joueur 2
        </button>
    </form>

    <form action="/bataille/scripts/reset_total.php" method="post">
        <button type="submit" name="reset_total">❌ Fin de partie (RESET)</button>
    </form>
</body>
</html>