<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$fichier = __DIR__ . '/etat_joueurs.json';
if (!file_exists($fichier)) {
    file_put_contents($fichier, json_encode(['j1' => null, 'j2' => null, 'tour' => 1]));
}

if (isset($_POST['joueur1'])) {
    $etat = json_decode(file_get_contents($fichier), true);
    if ($etat['j1'] === null) {
        $etat['j1']       = session_id();
        $_SESSION['role'] = 'joueur1';
        file_put_contents($fichier, json_encode($etat));
        header('Location: index.php');
        exit;
    }
}
if (isset($_POST['joueur2'])) {
    $etat = json_decode(file_get_contents($fichier), true);
    if ($etat['j2'] === null) {
        $etat['j2']       = session_id();
        $_SESSION['role'] = 'joueur2';
        file_put_contents($fichier, json_encode($etat));
        header('Location: index.php');
        exit;
    }
}

$etat = json_decode(file_get_contents($fichier), true);
$role = $_SESSION['role'] ?? 'Aucun rôle';

/* 4. initialisations session */
$_SESSION['MesBateauxCoules']     = $_SESSION['MesBateauxCoules']     ?? [];
$_SESSION['bateauxCoulesAdverse'] = $_SESSION['bateauxCoulesAdverse'] ?? [];
if (!isset($_SESSION['allPlaced'])) $_SESSION['allPlaced'] = false;

if (!isset($_SESSION['role'])) {
    include 'views/lobby.php';
    exit;
}

    // $MesBateauxCoules = $_SESSION['MesBateauxCoules'] ?? [];
    // $bateauxCoulesAdverse = $_SESSION['bateauxCoulesAdverse'] ?? [];
    // $role = $_SESSION["role"] ?? "Aucun rôle";

    if ($etat["j1"] != null && $etat["j2"] != null && isset($_SESSION["role"]) && ($_SESSION['MesBateauxCoules'] !== 5 || $_SESSION['bateauxCoulesAdverse']!== 5)) {
            include __DIR__ . '/views/choose_boat.php';
    } elseif ($etat["j1"] === null || $etat["j2"] === null) {
    include 'views/lobby.php';
    header('refresh:5');
    exit;
    }
    if (isset($_POST['play']) && $_SESSION['MesBateauxCoules'] != 5 || $_SESSION['bateauxCoulesAdverse'] != 5) {
            include __DIR__ . '/views/plateau.php';
            header('refresh:5');
    }


