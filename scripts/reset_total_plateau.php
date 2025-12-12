<?php
require_once __DIR__ . '/sqlConnect.php';
session_start();

$fichier = "../etat_joueurs.json";

function save_state($file, $data) {
  file_put_contents($file, json_encode($data));
}

$etat = json_decode(file_get_contents($fichier), true);
$sql = new SqlConnect();

if (isset($_POST["reset_total_plateau"])) {
    $updateQuery = 'UPDATE joueur1 SET checked = 0 , boat = null , choice = NULL';
    $updateReq = $sql->db->query($updateQuery);
    $updateQuery = 'UPDATE joueur2 SET checked = 0 , boat = null , choice = NULL';
    $updateReq = $sql->db->query($updateQuery);

  $etat = ["j1" => null, "j2" => null, "tour" => 1, "turn_count" => 1];
  save_state("../etat_joueurs.json", $etat);

  $_SESSION['allPlaced'] = false;
  $_SESSION['bateauxCoulesAdverse'] = [];
  $_SESSION['MesBateauxCoules'] = [];
  
  session_unset();
  session_destroy();

  header("Location: ../index.php");
  exit;
}