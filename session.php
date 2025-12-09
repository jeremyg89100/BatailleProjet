<?php
session_start();

$fichier = "etat_joueurs.json";

if (!file_exists($fichier)) {
  file_put_contents($fichier, json_encode(["j1" => null, "j2" => null]));
}

$etat = json_decode(file_get_contents($fichier), true);

if (!function_exists('save_state')) {
    function save_state($file, $data) {
        file_put_contents($file, json_encode($data));
    }
}

if (isset($_POST["joueur1"])) {
    if ($etat["j1"] === null) {
        $etat["j1"] = session_id();
        $_SESSION["role"] = "Joueur 1";
        save_state($fichier, $etat);
    }
}

if (isset($_POST["joueur2"])) {
    if ($etat["j2"] === null) {
        $etat["j2"] = session_id();
        $_SESSION["role"] = "Joueur 2";
        save_state($fichier, $etat);
    }
}

if ($etat["j1"] !== null && $etat["j2"] !== null) {
    if (isset($_SESSION["role"]) && $_SESSION["role"] !== null) {
        header('Location: views/plateau.php');
    }
}

// Détection automatique du rôle (si déjà assigné avant refresh)
$role = $_SESSION["role"] ?? "Aucun rôle";

header('refresh:5');

?>