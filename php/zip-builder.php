<?php
/**
 * zip-builder.php
 * Utilisé pour zipper un dossier de projet en .zip
 */

function zipFolder($source, $destination) {
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = realpath($source);
    if (is_dir($source)) {
        $iterator = new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {
            $filePath = realpath($file);
            $relativePath = substr($filePath, strlen($source) + 1);

            if (is_dir($filePath)) {
                $zip->addEmptyDir($relativePath);
            } else if (is_file($filePath)) {
                $zip->addFile($filePath, $relativePath);
            }
        }
    } else if (is_file($source)) {
        $zip->addFile($source, basename($source));
    }

    return $zip->close();
}

// Exemple d’utilisation
$folder = $_GET['folder'] ?? '';
$zipFile = $_GET['zip'] ?? '';

if (!$folder || !$zipFile) {
    http_response_code(400);
    echo "Paramètres manquants.";
    exit;
}

$source = "../data/jeux/$folder";
$zipDest = "../data/jeux/$zipFile";

if (zipFolder($source, $zipDest)) {
    echo json_encode(["success" => true, "zip" => $zipDest]);
} else {
    echo json_encode(["success" => false, "error" => "Erreur lors de la création du zip"]);
}
?>
