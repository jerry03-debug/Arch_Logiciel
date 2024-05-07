<?php
// Inclure le fichier de configuration
require_once 'config.php';

// En-tête pour indiquer le type de contenu
header("Content-Type: application/json");

try {
    // Créer une connexion PDO à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, $options);

    // Obtenir l'ID de l'article depuis le paramètre GET
    if (!isset($_GET['categorie'])) {
        // Si l'ID n'est pas fourni, renvoyer une erreur
        http_response_code(400);  // Erreur de requête
        echo json_encode(["error" => "ID de l'article requis"]);
        exit;
    }

    $articleId = intval($_GET['categorie']);  // Convertir en entier pour éviter les injections

    // Requête préparée pour récupérer l'article par ID
    $sql = "SELECT * FROM Article WHERE categorie = :categorie";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':categorie', $articleId, PDO::PARAM_INT);  // Lier le paramètre d'ID
    $stmt->execute();

    $article = $stmt->fetch();  // Utiliser fetch() pour récupérer un seul résultat

    // Si l'article est trouvé, renvoyer le résultat sous forme de JSON
    if ($article) {
        echo json_encode($article);
    } else {
        http_response_code(404);  // Code de réponse pour indiquer que l'article n'a pas été trouvé
        echo json_encode(["error" => "Article non trouvé"]);
    }
} catch (PDOException $e) {
    // Gérer les exceptions de base de données
    http_response_code(500);  // Erreur interne du serveur
    echo json_encode(["error" => "Erreur lors de la connexion à la base de données: " . $e->getMessage()]);
}
