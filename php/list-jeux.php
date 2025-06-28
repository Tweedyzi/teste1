<?php /* Liste les fichiers .zip dans data/jeux/[user_id] */ ?>

<?php
session_start();
header('Content-Type: application/json');

// Vérifie la session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Utilisateur non connecté"]);
    exit;
}

$userId = $_SESSION['user_id'];
$baseDir = "../data/jeux/$userId";
$baseUrl = "data/jeux/$userId";
$jeux = [];

if (file_exists($baseDir)) {
    $files = scandir($baseDir);
    foreach ($files as $file) {
        if (str_ends_with($file, ".zip")) {
            $filePath = "$baseDir/$file";
            $jeux[] = [
                "nom" => pathinfo($file, PATHINFO_FILENAME),
                "date" => date("Y-m-d H:i", filemtime($filePath)),
                "lien" => "$baseUrl/$file"
            ];
        }
    }
}

echo json_encode([
    "success" => true,
    "jeux" => $jeux
]);
?>
