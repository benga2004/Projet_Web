<?php
class WishlistController {

    /** POST /wishlist/toggle — retourne du JSON */
    public function toggle(): void {
        // Log pour debug
        error_log('[WISHLIST] toggle() called - method=' . $_SERVER['REQUEST_METHOD']
            . ' session_user_id=' . ($_SESSION['user_id'] ?? 'NULL')
            . ' post_offre_id=' . ($_POST['offre_id'] ?? 'NULL'));

        // Démarre un buffer propre pour capturer toute sortie accidentelle
        ob_start();

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                ob_end_clean();
                http_response_code(405);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['error' => 'method_not_allowed']);
                exit;
            }

            if (!isset($_SESSION['user_id'])) {
                ob_end_clean();
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['error' => 'not_logged_in']);
                exit;
            }

            $offreId = (int)($_POST['offre_id'] ?? 0);
            if (!$offreId) {
                ob_end_clean();
                http_response_code(400);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['error' => 'invalid_id']);
                exit;
            }

            $inWishlist = (new Wishlist())->toggle((int)$_SESSION['user_id'], $offreId);

            // Capture toute sortie parasite PHP
            $garbage = ob_get_clean();
            if ($garbage) {
                error_log('[WISHLIST] Garbage output captured: ' . $garbage);
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['in_wishlist' => $inWishlist]);
            exit;

        } catch (\Throwable $e) {
            ob_end_clean();
            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => 'server_error']);
            exit;
        }
    }

    /** GET /wishlist — page wishlist de l'étudiant connecté */
    public function index(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'connexion');
            exit;
        }

        $offres  = (new Wishlist())->getOffresByEtudiant((int)$_SESSION['user_id']);

        echo twig_render('wishlist.html.twig', ['offres' => $offres]);
    }
}
