<?php 

if (!isset($_SESSION['role'])) {
    header('Location: /bataille/index.php');
    exit;
}
    require_once 'sqlConnect.php';
    require_once __DIR__ . '/../config/Bateau.php';

    $bateaux = [
    new Bateau(1, "torpilleur", 2),
    new Bateau(2, "sous-marin1", 3),
    new Bateau(3, "sous-marin2", 3),
    new Bateau(4, "croiseur", 4),
    new Bateau(5, "porte-avion", 5)
];

$player = $_SESSION["role"] === 'joueur1' ? 'joueur2' : 'joueur1';
$tablePlayer = $_SESSION["role"] === 'joueur1' ? 'joueur2' : 'joueur1';

$sql = new SqlConnect();
$bateauxCoulesAdverse = [];

    foreach ($bateaux as $bateau) {
        $query = 'SELECT COUNT(*) AS touches FROM ' . $tablePlayer . ' WHERE boat = :boat AND checked = 1';
        $req = $sql->db->prepare($query);
        $req->execute(['boat'=>$bateau->id]);
        $result = $req->fetch(PDO::FETCH_ASSOC);

        $touched = $result['touches'];

        if ($touched == $bateau->size) {
            $bateauxCoulesAdverse[] = [
                'id'=> $bateau->id,
                'name'=> $bateau->name,
                'size'=> $bateau->size
            ];
        }
    }
    return $bateauxCoulesAdverse;


