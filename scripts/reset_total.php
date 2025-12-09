<?php
require_once 'session.php';

if (isset($_POST["reset_total"])) {
  $etat = ["j1" => null, "j2" => null];
  save_state($GLOBALS['fichier'], $etat);

  session_unset();
  session_destroy();

  header("Location: index.php");
  exit;
}

?>