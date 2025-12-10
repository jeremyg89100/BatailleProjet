<?php
require_once __DIR__ . '/sqlConnect.php';

$fichier = "../etat_joueurs.json";

function save_state($file, $data) {
  file_put_contents($file, json_encode($data));
}

$etat = json_decode(file_get_contents($fichier), true);
$sql = new SqlConnect();
$player = $_SESSION["role"] === 'joueur1' ? 'joueur2' : 'joueur1';

if (isset($_POST["reset_total_plateau"])) {
    $updateQuery = 'UPDATE joueur1 SET checked = 0 , boat = null';
    $updateReq = $sql->db->query($updateQuery);
    $updateQuery = 'UPDATE joueur2 SET checked = 0 , boat = null';
    $updateReq = $sql->db->query($updateQuery);

  $etat = ["j1" => null, "j2" => null];
  save_state("../etat_joueurs.json", $etat);
  
  session_unset();
  session_destroy();

  header("Location: ../index.php");
  exit;
}

?>