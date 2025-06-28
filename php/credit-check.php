<?php /* Vérifie crédits restants depuis users.json */ ?>

<?php
session_start();
header('Content-Type: application/json');

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(["error" => "Utilisateur non connecté"]);
    exit;
}

$usersFile = "../data/users.json";
if (!file_exists($usersFile)) {
    echo json_encode(["error" => "Fichier utilisateurs introuvable"]);
    exit;
}

$users = json_decode(file_get_contents($usersFile), true);

if (!isset($users[$userId])) {
    echo json_encode(["error" => "Utilisateur introuvable"]);
    exit;
}

echo json_encode([
    "success" => true,
    "credits" => $users[$userId]['credits'] ?? 0
]);
?>
