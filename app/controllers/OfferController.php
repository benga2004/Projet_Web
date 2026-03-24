<?php

// include '../models/Offer.php';

// $offres = Offer::getAll();

// $parPage = 5;
// $total   = count($offres);
// $pages   = ceil($total / $parPage);

// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $page = max(1, min($page, $pages));

// $debut      = ($page - 1) * $parPage;
// $offresPage = array_slice($offres, $debut, $parPage);

// require "../views/offers/list.php";

class OfferController {
    private int $parPage = 5;

    public function index(): void {
        $model   = new Offer();
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $query   = trim($_GET['query'] ?? '');
        $ville   = trim($_GET['ville'] ?? '');
        $domaine = trim($_GET['domaine'] ?? '');
        $offset  = ($page - 1) * $this->parPage;

        $offresPage = $model->search($query, $ville, $domaine, $this->parPage, $offset);
        $total      = $model->count();
        $pages      = (int)ceil($total / $this->parPage);

        require BASE_PATH . '/app/views/offers/list.php';
    }

    public function detail(): void {
        $id    = (int)($_GET['id'] ?? 0);
        $offre = (new Offer())->getById($id);
        if (!$offre) { http_response_code(404); require BASE_PATH . '/app/views/errors/404.php'; return; }
        require BASE_PATH . '/app/views/offers/detail.php';
    }

    public function addStep1(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['offer_step1'] = [
                'jobTitle'    => htmlspecialchars($_POST['jobTitle']),
                'mobilite'    => htmlspecialchars($_POST['mobilite']),
                'location'    => htmlspecialchars($_POST['location']),
                'delai'       => htmlspecialchars($_POST['delai']),
                'numberOfJob' => (int)$_POST['numberOfJob'],
            ];
            header('Location: ' . BASE_URL . 'offres/ajouter/etape2');
            exit;
        }
        require BASE_PATH . '/app/views/offers/ajout_offres_etape1.php';
    }

    public function addStep2(): void {
        if (!isset($_SESSION['offer_step1'])) {
            header('Location: ' . BASE_URL . 'offres/ajouter/etape1');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
            return;
        }
        require BASE_PATH . '/app/views/offers/ajout_offres_etape2.php';
    }

    public function store(): void {
        $step1 = $_SESSION['offer_step1'] ?? null;
        if (!$step1) { header('Location: ' . BASE_URL . 'offres/ajouter/etape1'); exit; }

        $data = array_merge($step1, [
            'description'  => $_POST['jobDescription'],
            'minSalary'    => (int)$_POST['minSalary'],
            'avantages'    => $_POST['avantages'] ?? [],
        ]);

        (new Offer())->create($data);
        unset($_SESSION['offer_step1']);
        header('Location: ' . BASE_URL . 'offres');
        exit;
    }
}