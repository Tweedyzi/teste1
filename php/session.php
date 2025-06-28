<?php include('php/session.php'); ?>

<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode([
        "success" => false,
        "error" => "Accès refusé : utilisateur non connecté."
    ]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../connexion.html");
    exit;
}

?>
