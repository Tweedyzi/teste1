<?php // Inscription utilisateur avec credits initiaux = 3 ?>

<?php
session_start();
header('Content-Type: application/json');

// Lire la base utilisateurs
$usersFile = "../data/users.json";
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

// Récupérer les données JSON envoyées
$data = json_decode(file_get_contents("php://input"), true);
$name = trim($data['name'] ?? '');
$email = strtolower(trim($data['email'] ?? ''));
$password = trim($data['password'] ?? '');

if (!$name || !$email || !$password) {
    echo json_encode(["success" => false, "error" => "Champs requis manquants."]);
    exit;
}

// Vérifie si l'email est déjà utilisé
foreach ($users as $user) {
    if ($user['email'] === $email) {
        echo json_encode(["success" => false, "error" => "Email déjà enregistré."]);
        exit;
    }
}

// Crée un nouvel utilisateur
$userId = uniqid();
$users[$userId] = [
    "name" => $name,
    "email" => $email,
    "password" => password_hash($password, PASSWORD_DEFAULT),
    "credits" => 3
];

// Sauvegarder
file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

// (Optionnel) Créer la session automatiquement :
$_SESSION['user_id'] = $userId;

echo json_encode(["success" => true]);
?>
