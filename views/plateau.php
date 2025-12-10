<?php
    include( __DIR__ . '/../scripts/sqlConnect.php');


    $sql = new SqlConnect();   
    $player = $_SESSION["role"] === 'joueur1' ? 'joueur2' : 'joueur1';

    if (isset($_POST['tir'])) {
        $tir = $_POST['tir'];

    $updateQuery = 'UPDATE ' . $player . ' SET checked = 1 WHERE idgrid = :position';
    $updateReq = $sql->db->prepare($updateQuery);
    $updateReq->execute(['position'=>$tir]);
}
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
</head>

<body>
    <main>
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
                            class="<?= $classe ?>">
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