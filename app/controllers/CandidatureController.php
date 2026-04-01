<?php
class CandidatureController {

    public function index(): void {
        try {
            $this->handleIndex();
        } catch (\Throwable $e) {
            error_log('[CANDIDATURE ERROR] ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            error_log('[CANDIDATURE TRACE] ' . $e->getTraceAsString());
            // Affiche l'erreur pour debug (à retirer en production)
            echo '<pre style="color:red;background:#fff;padding:20px;">';
            echo 'ERREUR: ' . htmlspecialchars($e->getMessage()) . "\n";
            echo 'Fichier: ' . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . "\n";
            echo htmlspecialchars($e->getTraceAsString());
            echo '</pre>';
            exit;
        }
    }

    private function handleIndex(): void {
        // Guard: doit être connecté
        if (empty($_SESSION['user_id'])) {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            header('Location: ' . BASE_URL . 'connexion' . ($id ? '?redirect=candidature%3Fid%3D' . $id : ''));
            exit;
        }

        $erreurs     = [];
        $succes      = '';
        $offre_id    = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $etudiant_id = (int)$_SESSION['user_id'];

        // Charger les infos utilisateur pour pré-remplir le formulaire
        $user = (new User())->findById($etudiant_id);

        // Si le user_id en session ne correspond à aucun utilisateur en base,
        // la session est obsolète → forcer une reconnexion
        if (empty($user)) {
            session_unset();
            session_destroy();
            header('Location: ' . BASE_URL . 'connexion');
            exit;
        }

        if (!$offre_id) {
            $erreurs[] = 'Aucune offre sélectionnée.';
        }

        // PRG : afficher le message de succès après redirect
        if ($offre_id && isset($_GET['succes'])) {
            $prenom = $user['prenom'] ?? ($_SESSION['user_prenom'] ?? 'Étudiant');
            $succes = htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $offre_id && empty($succes)) {
            $lettre = trim($_POST['lettre'] ?? '');

            if (!$lettre) $erreurs[] = 'La lettre de motivation est obligatoire.';

            // Vérifier doublon
            if (empty($erreurs) && Candidature::alreadyApplied($offre_id, $etudiant_id)) {
                $erreurs[] = 'Vous avez déjà postulé à cette offre.';
            }

            // Validation fichier CV
            if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
                $erreurs[] = 'CV obligatoire (PDF).';
            } else {
                // Vérifier l'extension
                $ext = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
                if ($ext !== 'pdf') {
                    $erreurs[] = 'Le CV doit être un fichier PDF.';
                }
                // Vérifier les magic bytes (signature PDF : %PDF)
                $header = file_get_contents($_FILES['cv']['tmp_name'], false, null, 0, 5);
                if (strpos($header, '%PDF') !== 0) {
                    $erreurs[] = 'Le fichier ne semble pas être un PDF valide.';
                }
                // Vérifier la taille (2 Mo max)
                if ($_FILES['cv']['size'] > 2 * 1024 * 1024) {
                    $erreurs[] = 'Le CV ne doit pas dépasser 2 Mo.';
                }
            }

            // Sauvegarde si pas d'erreurs
            if (empty($erreurs)) {
                $uploadDir = BASE_PATH . '/public/uploads/cv/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = uniqid() . '.pdf';
                $cvPath   = 'uploads/cv/' . $filename;
                $fullPath = BASE_PATH . '/public/' . $cvPath;

                if (move_uploaded_file($_FILES['cv']['tmp_name'], $fullPath)) {
                    if (Candidature::postuler($offre_id, $etudiant_id, $cvPath, $lettre)) {
                        header('Location: ' . BASE_URL . 'candidature?id=' . $offre_id . '&succes=1');
                        exit;
                    } else {
                        $erreurs[] = 'Erreur lors de l\'enregistrement de la candidature.';
                    }
                } else {
                    $erreurs[] = 'Erreur lors du téléversement du CV.';
                }
            }
        }

        echo twig_render('offers/candidature.html.twig', [
            'erreurs'       => $erreurs,
            'succes'        => $succes,
            'offre_id'      => $offre_id,
            'user'          => $user,
            'post_prenom'   => $_POST['prenom']  ?? '',
            'post_nom'      => $_POST['nom']     ?? '',
            'post_email'    => $_POST['email']   ?? '',
            'post_lettre'   => $_POST['lettre']  ?? '',
        ]);
    }
}