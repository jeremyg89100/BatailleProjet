<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$fichier = "./etat_joueurs.json";

if (!file_exists($fichier)) {
  file_put_contents($fichier, json_encode(["j1" => null, "j2" => null]));
}

$etat = json_decode(file_get_contents($fichier), true);

if ($etat["j1"] != null && $etat["j2"] != null) {
  include ('views/plateau.php');
} else {
  include ('views/lobby.php');
  header('refresh:3');
}