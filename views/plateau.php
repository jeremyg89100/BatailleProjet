<?php
$plateauJ1 = [
    "A1" => 2,  // Torpilleur 
    "A2" => 2,  // Torpilleur 
    "C5" => 3,  // Sous-marin 
    "C6" => 3,  // Sous-marin 
    "C7" => 3,  // Sous-marin 
];

// Tableau pour stocker les tirs
$shot = [];

// Simuler des tirs
if (isset($_POST['tir'])) {
    $shot[] = $_POST['tir'];
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
                $boat = isset($plateauJ1[$position]); 
                $isShot = in_array($position, $shot); 
                
                if ($isShot && $boat) {
                    $classe = "touched";
                    $texte = "💥";
                } elseif ($isShot && !$boat) {
                    $classe = "missed";
                    $texte = "💧";
                } elseif ($boat) {
                    $classe = "bateau";
                    $texte = $plateauJ1[$position]; 
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
        <form action="../scripts/reset_total.php" method="post">
            <button type="submit" name="reset_total">
                ❌ Fin de partie (RESET)
            </button>
        </form>
    </main>
</body>

</html>