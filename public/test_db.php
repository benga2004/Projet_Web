<?php
require_once '../app/bootstrap.php';

try {
    $pdo = Database::connect();
    echo '✅ Connexion réussie !';
} catch (Exception $e) {
    echo '❌ Erreur : ' . $e->getMessage();
}