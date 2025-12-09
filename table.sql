CREATE TABLE joueurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pseudo VARCHAR(50) UNIQUE NOT NULL,
    parties_gagnees INT DEFAULT 0,
    parties_jouees INT DEFAULT 0,
);

CREATE TABLE joueurs_attente (
    id INT PRIMARY KEY AUTO_INCREMENT,
    session_id VARCHAR(100) NOT NULL,
    role ENUM('joueur1', 'joueur2') NOT NULL,
    joueur_definitif_id INT NULL,
    UNIQUE KEY unique_role (role)
);

CREATE TABLE parties (
    id INT PRIMARY KEY AUTO_INCREMENT,
    joueur1_id INT NOT NULL,
    joueur2_id INT NOT NULL,
    tour_joueur_id INT NULL,
    statut ENUM('en_cours', 'terminee') DEFAULT 'en_cours',
    gagnant_id INT NULL,
    FOREIGN KEY (joueur1_id) REFERENCES joueurs(id),
    FOREIGN KEY (joueur2_id) REFERENCES joueurs(id)
);

CREATE TABLE grilles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    partie_id INT NOT NULL,
    joueur_id INT NOT NULL,
    position VARCHAR(3) NOT NULL,
    contenu ENUM('vide', 'bateau', 'touche', 'rate') DEFAULT 'vide',
    visible BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (partie_id) REFERENCES parties(id), (Sécurité pour que le tir soit bien dans une partie existante)
    FOREIGN KEY (joueur_id) REFERENCES joueurs(id)
);

CREATE TABLE tirs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    partie_id INT NOT NULL,
    joueur_id INT NOT NULL,
    position VARCHAR(3) NOT NULL,
    resultat ENUM('touche', 'rate', 'coule') DEFAULT 'rate',
    FOREIGN KEY (partie_id) REFERENCES parties(id),  (Sécurité pour que le tir soit bien dans une partie existante)
    FOREIGN KEY (joueur_id) REFERENCES joueurs(id)
);