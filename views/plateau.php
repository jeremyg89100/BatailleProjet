<?php

    include __DIR__ . '/../scripts/sqlConnect.php';

    $sql = new SqlConnect();   
    $player = $_SESSION["role"] === 'joueur1' ? 'joueur2' : 'joueur1';

    // **** Players taking turns before shooting *****
    $mySide = $_SESSION["role"];
    $numberTurn = $mySide === 'joueur1' ? 1 : 2;

    $etat      = json_decode(file_get_contents(__DIR__.'/../etat_joueurs.json'),true);
    $turn = $etat['tour'];
    $myTurn = ($numberTurn === $turn);

    $disabled = $myTurn ? '' : 'disabled';
    if (isset($_POST['tir']) && $myTurn) {
        $tir = $_POST['tir'];

    $updateQuery = 'UPDATE ' . $player . ' SET checked = 1 WHERE idgrid = :position';
    $updateReq = $sql->db->prepare($updateQuery);
    $updateReq->execute(['position'=>$tir]);

    $etat['tour'] = ($etat['tour'] === 1) ? 2 : 1;
    file_put_contents(__DIR__.'/../etat_joueurs.json', json_encode($etat));

    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}

// **** Initialize DB and board ******

    try {
        $query = 'SELECT * FROM '. $player;
        $req = $sql->db->prepare($query);
        $req->execute();
        $rows = $req->fetchAll(PDO::FETCH_ASSOC);

        $plateau = [];
        foreach ($rows as $row) {
            $plateau[$row['idgrid']] = ['boat' => $row['boat'],
            'checked' => $row['checked']
            ];
        }
    
    } catch (Exception $e) {
        echo "❌ Erreur : " . $e->getMessage() . "<br>";
    }
    $bateauxCoulesAdverse = include(__DIR__ . '/../scripts/AdversaryBoatDestroyed.php');
    $MesBateauxCoules = include(__DIR__ . '/../scripts/MyBoatDestroyed.php');

    $gameOver = (count($MesBateauxCoules) === 5 || count($bateauxCoulesAdverse) === 5);

    //Placing boats before launching the game

    $queryJ1 = 'SELECT COUNT(*) as total FROM joueur1 WHERE boat IS NOT NULL';
    $reqJ1 = $sql->db->query($queryJ1);
    $totalJ1 = $reqJ1->fetch(PDO::FETCH_ASSOC)['total'];

    $queryJ2 = 'SELECT COUNT(*) as total FROM joueur2 WHERE boat IS NOT NULL';
    $reqJ2 = $sql->db->query($queryJ2);
    $totalJ2 = $reqJ2->fetch(PDO::FETCH_ASSOC)['total'];

    $bateauxPlaces = ($totalJ1 >= 17 && $totalJ2 >= 17);

    $disabled = (!$bateauxPlaces || !$myTurn) ? 'disabled' : '';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jeu</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

    <?php if (!$myTurn && !$gameOver): ?>
        <meta http-equiv="refresh" content="3">
    <?php endif; ?>
</head>

<body>
    <main>
        <?php if (!$bateauxPlaces): ?>
            <div>
                <h3>Placements des bateaux en cours...</h3>
            </div>
        <?php endif; ?>
    <?php if ($bateauxPlaces && !$gameOver): ?>
        <div>
            <h3><?= $myTurn ? "Mon tour" : "Tour de l'adversaire..." ?></h3>
        </div>
    <?php endif; ?>
        <?php if (!empty($bateauxCoulesAdverse)):?>
            <div>
                <h3>Bateaux coulés !</h3>
                <?php $compteur = 0;
                    foreach ($bateauxCoulesAdverse as $bateau):
                    $compteur ++;
                ?>
                    <p>Nombre de bateaux coulés : <?= $compteur ?></p>
                    <p> <?= htmlspecialchars($bateau['name']) ?> a coulé !</p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if(count($bateauxCoulesAdverse) === 5): ?>
            <h1>Victoire !</h1>
        <?php elseif (count($MesBateauxCoules) === 5): ?>
            <h1>Defaite !</h1>
        <?php endif; ?>
        <form method="post">
            <table>
                <caption>Plateau joueur 1</caption>
                <tr>
                    <th></th>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                    <th scope="col"><?= $i ?></th>
                    <?php endfor; ?>
                </tr>

                <?php
            $lettres = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
            foreach ($lettres as $lettre):
            ?>
                <tr>
                    <th scope="row"><?= $lettre ?></th>
                    <?php for ($i = 1; $i <= 10; $i++): 
                $position = $lettre . $i;
                $boat = isset($plateau[$position]) && $plateau[$position]['boat'] != null; 
                $isShot = isset($plateau[$position]) && $plateau[$position]['checked'] == 1; 
                    

                if ($isShot && $boat) {
                    $classe = "touched";
                    $texte = "💥";
                } elseif ($isShot && !$boat) {
                    $classe = "missed";
                    $texte = "💧";
                } elseif ($boat) {
                    $classe = "";
                    $texte = "";
                } else {
                    $classe = "";
                    $texte = "";
                }
            ?>
                    <td>
                        <button class="buttonPlateau" type="submit" name="tir" value="<?= $position ?>"
                            class="<?= $classe ?>"<?= $disabled ?>>
                            <?= $texte ?>
                        </button>
                    </td>
                    <?php endfor; ?>
                </tr>
                <?php endforeach; ?>
            </table>
        </form>
        <form action="/bataille/scripts/reset_total_plateau.php" method="post">
            <button type="submit" name="reset_total_plateau">
                ❌ Fin de partie (RESET)
            </button>
        </form>
    </main>
</body>

</html>