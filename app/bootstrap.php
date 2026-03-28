<?php
session_start();
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/');

// Modèles
require_once BASE_PATH . '/app/models/Database.php';
require_once BASE_PATH . '/app/models/Offer.php';
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/models/Company.php';
require_once BASE_PATH . '/app/models/Candidature.php';
require_once BASE_PATH . '/app/models/Wishlist.php';

// Contrôleurs
require_once BASE_PATH . '/app/controllers/AuthController.php';
require_once BASE_PATH . '/app/controllers/OfferController.php';
require_once BASE_PATH . '/app/controllers/AdminController.php';
require_once BASE_PATH . '/app/controllers/CandidatureController.php';
require_once BASE_PATH . '/app/controllers/EtudiantController.php';
require_once BASE_PATH . '/app/controllers/EntrepriseController.php';
require_once BASE_PATH . '/app/controllers/WishlistController.php';
require_once BASE_PATH . '/app/controllers/PiloteController.php';

// hashage CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}