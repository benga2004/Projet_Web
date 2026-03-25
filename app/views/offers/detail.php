<?php

$title = "Détails de l'offre - StageHub.fr";
$content = "Découvrez les missions, le profil recherché et les conditions de l'offre de stage. Postulez dès maintenant pour rejoindre une entreprise dynamique et enrichir votre expérience professionnelle.";
require __DIR__ . '/../layout/header.php';


/* / ── Récupération de l'id ──────────────────────────────────
$id = isset($_GET['id']) ? (int)$_GET['id'] : -1;

// ── Vérification que l'offre existe ──────────────────────
if (!isset($offres[$id])) {
    $offre = null;
} else {
    $offre = $offres[$id];
}*/
?>

<a href="<?= BASE_URL ?>offres">← Retour aux offres</a>

    <h1><?= htmlspecialchars($offre['titre'],      ENT_QUOTES, 'UTF-8') ?></h1>
    <h2><?= htmlspecialchars($company['nom'], ENT_QUOTES, 'UTF-8') ?></h2>

    <hr>

    <p><strong>Ville :</strong>        <?= htmlspecialchars($offre['ville'],        ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Durée :</strong>        <?= htmlspecialchars($offre['duree'],        ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Domaine :</strong>      <?= htmlspecialchars($offre['domaine'],      ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Rémunération :</strong> <?= htmlspecialchars($offre['remuneration'], ENT_QUOTES, 'UTF-8') ?></p>
    <p class="date"><?= htmlspecialchars($offre['date_offre'], ENT_QUOTES, 'UTF-8') ?></p>

    <hr>

    <h3>Description</h3>
    <p><?= htmlspecialchars($offre['description'], ENT_QUOTES, 'UTF-8') ?></p>

    <hr>

    <a href="<?= BASE_URL ?>candidature?id=<?= $id ?>">Postuler à cette offre</a>

<?php require __DIR__ . '/../layout/footer.php'; ?>