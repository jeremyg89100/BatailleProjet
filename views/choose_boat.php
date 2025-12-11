<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../scripts/sqlConnect.php';

$sql = new SqlConnect();
$player = $_SESSION["role"];

$boats = [
    1 => ["name" => "Torpilleur", "size" => 2],
    2 => ["name" => "Sous-marin 1", "size" => 3],
    3 => ["name" => "Sous-marin 2", "size" => 3],
    4 => ["name" => "Croiseur", "size" => 4],
    5 => ["name" => "Porte-avion", "size" => 5],
];

if (isset($_POST['select_boat'])) {
    // $_SESSION enregistre les choix pour toute la session
    $_SESSION['selected_boat'] = $_POST['boat_id'];
}

//Enregistre la case du bateaux selectionné
if (isset($_POST['placed']) && isset($_SESSION['selected_boat'])) {
    //les id sont enregistrés pour toute la session
    $boatId = $_SESSION['selected_boat'];
    $position = $_POST['placed'];

    //verifie si la taille du bateau n'a pas été dépassé
    $query = "SELECT COUNT(*) AS CountSize FROM $player WHERE choice = :boatId";
    $req = $sql->db->prepare($query);
    $req->execute(['boatId' => $boatId]);
    $CountSize = $req->fetch()['CountSize'];

    if ($CountSize < $boats[$boatId]['size']) {
        $query = "UPDATE $player SET choice = :boat WHERE idgrid = :position";
        $req = $sql->db->prepare($query);
        $req->execute(['boat' => $boatId, 'position' => $position]);
    } else {
        echo "<h3> Bateau déjà placé </h3>";
    }
}

//Met à jour le plateau avec les bateaux
$query = "SELECT * FROM $player";
$req = $sql->db->prepare($query);
$req->execute();
$rows = $req->fetchAll(PDO::FETCH_ASSOC);

$grille = [];
foreach ($rows as $row) {
    $grille[$row['idgrid']] = [
        'choice' => $row['choice']
    ];
}

$allPlaced = true;
//Compte le nombre de bateaux qu'on a placé grâce à leur id
foreach ($boats as $id => $boat) {
    $query = "SELECT COUNT(*) AS count FROM $player WHERE choice = :id";
    $req = $sql->db->prepare($query);
    $req->execute(['id'=>$id]);
    $count = $req->fetch()['count'];

    if ($count != $boat['size']) {
        $allPlaced = false;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Placement des bateaux</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>

        <h2>Placer vos bateaux</h2>

        <form method="post">
            <label for="boat_id">Choisissez un bateau :</label>

            <select name="boat_id" id="boat_id">
                <?php foreach ($boats as $id => $boat): ?>
                <option value="<?php echo $id; ?>" <?php 
                    if (isset($_SESSION['selected_boat']) && $_SESSION['selected_boat'] == $id) {
                        echo "selected";
                    }
                    ?>>
                    <?php echo $boat["name"] . " (taille : " . $boat["size"] . ")"; ?>
                </option>

                <?php endforeach; ?>
            </select>

            <button type="submit" name="select_boat">Sélectionner</button>
        </form>

        <p>
            Bateau sélectionné :
            <strong>
                <?php
                    if (isset($_SESSION['selected_boat'])) {
                        echo $boats[$_SESSION['selected_boat']]['name'];
                    } else {
                        echo "Aucun";
                    }
                    ?>
            </strong>

        </p>

        <!--LA GRILLE -->
        <form method="post">
            <table>
                <caption>Placer vos bateaux</caption>

                <tr>
                    <th></th>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                    <th scope="col"><?= $i ?></th>
                    <?php endfor; ?>
                </tr>

                <?php
            $lettres = ['A','B','C','D','E','F','G','H','I','J'];
            foreach ($lettres as $lettre):
            ?>
                <tr>
                    <th scope="row"><?= $lettre ?></th>
                    <?php for ($i = 1; $i <= 10; $i++): 
                        $position = $lettre . $i;
                        $BoatExist = isset($grille[$position]) && $grille[$position]['choice'] != null;
                    ?>
                    <td>
                        <button class="buttonPlateau" type="submit" name="placed" value="<?= $position ?>"
                            class="<?= $classe ?>">
                            <?php 
                            if ($BoatExist) {
                                echo "🛥️";
                            }
                            ?>

                        </button>
                    </td>
                    <?php endfor; ?>
                </tr>
                <?php endforeach; ?>
            </table>
            <td>
        </form>
        <form action="../scripts/reset_total_plateau.php" method="post">
            <button type="submit" name="reset_total_plateau">
                ❌ Fin de partie (RESET)
            </button>
        </form>
        <?php if ($allPlaced): ?>
        <form action="plateau.php" method="post">
            <button type="submit" class="jouer"> Jouer </button>
        </form>
        <?php endif; ?>

    </main>
</body>

</html>