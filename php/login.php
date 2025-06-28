<?php // Connexion utilisateur avec session et users.json ?>

<?php
session_start();
header('Content-Type: application/json');

// Charger les utilisateurs
$usersFile = "../data/users.json";
if (!file_exists($usersFile)) {
    echo json_encode(["success" => false, "error" => "Aucun utilisateur trouvé"]);
    exit;
}
$users = json_decode(file_get_contents($usersFile), true);

// Récupérer les données POST (JSON)
$data = json_decode(file_get_contents("php://input"), true);
$email = strtolower(trim($data['email'] ?? ''));
$password = trim($data['password'] ?? '');

if (!$email || !$password) {
    echo json_encode(["success" => false, "error" => "Champs requis manquants"]);
    exit;
}

// Recherche de l'utilisateur
foreach ($users as $id => $user) {
    if ($user['email'] === $email && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $id;
        echo json_encode(["success" => true]);
        exit;
    }
}

// Si aucun match
echo json_encode(["success" => false, "error" => "Email ou mot de passe incorrect"]);
exit;
?>
