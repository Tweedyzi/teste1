<?php /* Contenu réel de generate.php comme donné plus tôt */ ?>

<?php
session_start();
header('Content-Type: application/json');

// Charger la config OpenAI
require_once '../config.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(["error" => "Utilisateur non connecté"]);
    exit;
}

// Charger les utilisateurs
$usersFile = "../data/users.json";
$users = json_decode(file_get_contents($usersFile), true);

// Vérifier crédits
if (!isset($users[$userId]) || $users[$userId]['credits'] <= 0) {
    echo json_encode(["error" => "Crédits épuisés"]);
    exit;
}

// Lire le JSON reçu
$data = json_decode(file_get_contents("php://input"), true);
$prompt = $data['prompt'] ?? '';
$platform = $data['platform'] ?? 'html5';

if (!$prompt) {
    echo json_encode(["error" => "Prompt vide"]);
    exit;
}

// Appel OpenAI
$openaiEndpoint = "https://api.openai.com/v1/chat/completions";
$postData = [
    "model" => "gpt-4",
    "messages" => [
        ["role" => "system", "content" => "Tu es un générateur de jeux vidéo."],
        ["role" => "user", "content" => "Crée un projet de jeu pour $platform basé sur : $prompt"]
    ],
    "temperature" => 0.7
];

$ch = curl_init($openaiEndpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . OPENAI_API_KEY,
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
$response = curl_exec($ch);
curl_close($ch);

// Récupérer réponse IA
$data = json_decode($response, true);
$contenu = $data['choices'][0]['message']['content'] ?? 'Pas de contenu généré.';

// Créer dossier projet
$timestamp = time();
$projectName = "jeu_$timestamp";
$projectPath = "../data/jeux/$userId/$projectName";
mkdir($projectPath, 0777, true);

// Enregistrer contenu IA
file_put_contents("$projectPath/README.txt", $contenu);

// Générer fichiers selon la plateforme
if ($platform === 'html5') {
    file_put_contents("$projectPath/index.html", "<!DOCTYPE html><html><body><h1>$prompt</h1></body></html>");
    file_put_contents("$projectPath/style.css", "body { background: #000; color: #fff; }");
    file_put_contents("$projectPath/game.js", "console.log('Jeu HTML5 généré');");
} else {
    file_put_contents("$projectPath/project.godot", "[gd_project]");
    file_put_contents("$projectPath/main.tscn", "[node name=\"Main\" type=\"Node2D\"]");
    file_put_contents("$projectPath/main.gd", "extends Node2D\nfunc _ready():\n    print(\"Jeu prêt !\")");
}

// Créer le fichier ZIP
$zipFile = "../data/jeux/$userId/$projectName.zip";
$zip = new ZipArchive;
if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
    foreach (scandir($projectPath) as $file) {
        if (!in_array($file, ['.', '..'])) {
            $zip->addFile("$projectPath/$file", $file);
        }
    }
    $zip->close();
}

// Décrémenter crédit utilisateur
$users[$userId]['credits']--;
file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

// Retour JSON
echo json_encode([
    "choices" => [[ "message" => ["content" => $contenu] ]],
    "zip_url" => "$zipFile"
]);
?>
