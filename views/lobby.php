<?php
function save_state($file, $data) {
    file_put_contents($file, json_encode($data));
}


if (isset($_POST["joueur1"])) {
    if ($etat["j1"] === null) {
        $etat["j1"] = session_id();
        $_SESSION["role"] = "Joueur 1";
        save_state("./etat_joueurs.json", $etat);
    }
}

if (isset($_POST["joueur2"])) {
    if ($etat["j2"] === null) {
        $etat["j2"] = session_id();
        $_SESSION["role"] = "Joueur 2";
        save_state("./etat_joueurs.json", $etat);
    }
}

// Détection automatique du rôle (si déjà assigné avant refresh)
$role = $_SESSION["role"] ?? "Aucun rôle";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Joueur 1 / Joueur 2</title>
</head>

<body>
    <h1>Connexion aux rôles</h1>
    <h2>Votre rôle actuel : <strong><?= $role ?></strong></h2>
    <p>
        Joueur 1 : <?= $etat["j1"] ? "🟢 Occupé" : "🔴 Libre" ?><br>
        Joueur 2 : <?= $etat["j2"] ? "🟢 Occupé" : "🔴 Libre" ?>
    </p>

    <form method="post">
        <button type="submit" name="joueur1" class="button1"
            <?= ($etat["j1"] !== null || $etat["j2"] === session_id()) ? "disabled" : "" ?>>
            🎮 Devenir Joueur 1
        </button>
        <button type="submit" name="joueur2" class="button2"
            <?= ($etat["j2"] !== null || $etat["j1"] === session_id()) ? "disabled" : "" ?>>
            🎮 Devenir Joueur 2
        </button>
    </form>
    <form action="../scripts/reset_total.php" method="post">
        <button type="submit" name="reset_total">
            ❌ Fin de partie (RESET)
        </button>
    </form>
</body>

</html>