<?php 

    require_once '../config/Bateau.php';

    $bateaux = [
    new Bateau(1, "torpilleur", 2),
    new Bateau(2, "sous-marin1", 3),
    new Bateau(3, "sous-marin2", 3),
    new Bateau(4, "croiseur", 4),
    new Bateau(5, "porte-avion", 5)
];

$player = $_SESSION["role"] === 'joueur1' ? 'joueur2' : 'joueur1';

$sql = new SqlConnect();
$bateauxCoules = [];

    foreach ($bateaux as $bateau) {
        $query = 'SELECT COUNT(*) AS touches FROM ' . $player . 'WHERE boat = :boat, checked = 1';
        $req = $sql->$db->prepare($query);
        $req->execute(['boat'=>$bateau->id]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
    

        $touched = $result['touches'];

        if ($casesTouchees == $bateau->size) {
            $bateauxCoules[] = [
                'id'-> $bateau->id,
                'name'-> $bateau->name,
                'size'-> $bateau->size
            ];
        }
    }

    foreach ($bateaux as $bateau) {
    if ($touched == $bateau->id) {
        
    }

    }

    if (count($bateauxCoules) === count($bateaux)) {
        echo 'Victoire';
    }
    else {
        echo 'Defaite';
    }



