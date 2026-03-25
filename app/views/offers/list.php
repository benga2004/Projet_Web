


<!--
<h1>Offres de stage</h1>
<section id="search-bar" aria-label="Rechercher une offre">
    <form action="" method="get" class="search-form" autocomplete="off">
        <div class="field">
            <label for="company-search" class="field-label">
                <i class="fas fa-building" aria-hidden="true"></i>
            </label>
            <input id="company-search" class="field-input" type="search" name="query" placeholder="Entreprise, profil, compétence...">
        </div>

        <div class="field">
            <label for="city-search" class="field-label">
                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
            </label>
            <input id="city-search" class="field-input" type="text" name="ville" placeholder="Ville">
        </div>

        <div class="field">
            <label for="domain-search" class="field-label">
                <i class="fas fa-briefcase" aria-hidden="true"></i>
            </label>
            <select id="domain-search" name="domaine" class="field-input">
                <option value="">Tous les domaines</option>
                <option value="informatique">Informatique</option>
                <option value="marketing">Marketing</option>
                <option value="industrie">Industrie</option>
                <option value="design">Design</option>
                <option value="finance">Finance</option>
            </select>
        </div>

        <button type="submit" class="search-button">Rechercher</button>
    </form>
</section> -->

<p class="info">
<?= $total ?> offres disponibles
</p>

<?php foreach ($offresPage as $offre): ?>

<div class="offer-card">

<h2><?= htmlspecialchars($offre['titre']) ?></h2>

<p class="company"><?= htmlspecialchars($companyModel->getById($offre['entreprise_id'])['nom']) ?></p>

<p>Ville : <?= htmlspecialchars($offre['ville']) ?></p>

<p>Durée : <?= htmlspecialchars($offre['duree']) ?></p>

<p>Domaine : <?= htmlspecialchars($offre['domaine']) ?></p>

<a href="<?= BASE_URL ?>offres/detail?id=<?= $offre['id'] ?>">Détails</a>

</div>

<?php endforeach; ?>

<!-- Pagination -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">&#8249; Précédent</a>
    <?php endif; ?>
    <?= $page ?>/<?= $pages?> 

    <?php if ($page < $pages): ?>
        <a href="?page=<?= $page + 1 ?>">Suivant &#8250;</a>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
