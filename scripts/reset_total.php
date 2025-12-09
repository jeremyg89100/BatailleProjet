<?php
$fichier = "../etat_joueurs.json";

function save_state($file, $data) {
  file_put_contents($file, json_encode($data));
}

$etat = json_decode(file_get_contents($fichier), true);

if (isset($_POST["reset_total"])) {
  $etat = ["j1" => null, "j2" => null];
  save_state("../etat_joueurs.json", $etat);
  
  session_unset();
  session_destroy();

  header("Location: ../index.php");
  exit;
}

?>