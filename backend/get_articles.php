<?php
// Inclure le fichier de configuration
require_once 'config.php';

// En-tête pour indiquer le type de contenu
header("Content-Type: application/json");

try {
    // Créer une connexion PDO à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, $options);

    // Écrire la requête SQL pour récupérer les utilisateurs
    $sql = "SELECT * FROM Article";

    // Exécuter la requête
    $stmt = $pdo->query($sql);

    // Récupérer tous les résultats
    $articles = $stmt->fetchAll();

    // Si des utilisateurs sont trouvés, renvoyer les résultats sous forme de JSON
    if ($articles) {
        echo json_encode($articles);
    } else {
        http_response_code(404);  // Code de réponse pour indiquer qu'il n'y a pas de données
        echo json_encode(["error" => "Aucun utilisateur trouvé"]);
    }
} catch (PDOException $e) {
    // Gérer les exceptions de base de données
    http_response_code(500);  // Code de réponse pour une erreur interne du serveur
    echo json_encode(["error" => "Erreur lors de la connexion à la base de données: " . $e->getMessage()]);
}
?>
