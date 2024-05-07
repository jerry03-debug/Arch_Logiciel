<?php
// config.php
// Définir les détails de connexion à la base de données
$host = 'localhost';  // Nom de l'hôte
$dbname = 'mglsi_news';  // Nom de la base de données
$user = 'diery';  // Nom d'utilisateur
$pass = 'passer';  // Mot de passe

// Options supplémentaires pour PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Gérer les erreurs avec des exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Format de récupération par défaut
    PDO::ATTR_EMULATE_PREPARES => false,  // Éviter l'émulation des requêtes préparées
];
?>
