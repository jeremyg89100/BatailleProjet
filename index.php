<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

 $_SESSION['allPlaced'] = false;

$fichier = __DIR__ . "/etat_joueurs.json";
if (!file_exists($fichier)) {
    file_put_contents($fichier, json_encode(["j1" => null, "j2" => null, "tour" => 1]));
}
$etat = json_decode(file_get_contents($fichier), true);

function save_state($file, $data) {
    file_put_contents($file, json_encode($data));
}

if (isset($_POST["joueur1"])) {
    if ($etat["j1"] === null) {
        $etat["j1"] = session_id();
        $_SESSION["role"] = "joueur1";
        save_state($fichier, $etat);
        header('Location: index.php');
        exit();
    }
}

if (isset($_POST["joueur2"])) {
    if ($etat["j2"] === null) {
        $etat["j2"] = session_id();
        $_SESSION["role"] = "joueur2";
        save_state($fichier, $etat);
        header('Location: index.php');
        exit();
    }
}
    $bateauxCoulesAdverse = require_once (__DIR__ . '/scripts/AdversaryBoatDestroyed.php');
    $MesBateauxCoules = require_once (__DIR__ . '/scripts/MyBoatDestroyed.php');
    $role = $_SESSION["role"] ?? "Aucun rôle";

    if ($etat["j1"] != null && $etat["j2"] != null && isset($_SESSION["role"]) && ($MesBateauxCoules !== 5 || $bateauxCoulesAdverse !== 5)) {
            include __DIR__ . '/views/choose_boat.php';
    } else {
    include 'views/lobby.php';
    }
    if (isset($_SESSION["role"])) {
        header('refresh:3');
    }
    if (isset($_POST['play']) || $MesBateauxCoules !== 5 || $bateauxCoulesAdverse !== 5) {
            include __DIR__ . '/views/plateau.php';
    }
