<div class="wishlist-page">

    <div class="legal-hero">
        <div class="legal-hero-icon"><i class="fas fa-bookmark" aria-hidden="true"></i></div>
        <h1>Ma Wishlist</h1>
        <p>
            <?php if (empty($offres)): ?>
                Vous n'avez pas encore sauvegardé d'offre.
            <?php else: ?>
                <?= count($offres) ?> offre<?= count($offres) > 1 ? 's' : '' ?> sauvegardée<?= count($offres) > 1 ? 's' : '' ?>
            <?php endif; ?>
        </p>
    </div>

    <?php if (empty($offres)): ?>
    <div class="wishlist-empty">
        <i class="far fa-bookmark"></i>
        <p>Parcourez les offres et cliquez sur <i class="fas fa-bookmark" style="color:#667eea"></i> pour les sauvegarder ici.</p>
        <a href="<?= BASE_URL ?>offres" class="btn btn-primary">Voir les offres</a>
    </div>
    <?php else: ?>
    <div class="wishlist-grid">
        <?php foreach ($offres as $offre): ?>
        <div class="offer-card" id="wl-card-<?= $offre['id'] ?>">
            <div class="offer-card-header">
                <h2><?= htmlspecialchars($offre['titre']) ?></h2>
                <button class="wishlist-btn active"
                        type="button"
                        data-offre="<?= $offre['id'] ?>"
                        title="Retirer de la wishlist">
                    <i class="fas fa-bookmark"></i>
                </button>
            </div>
            <p class="company"><i class="fas fa-building"></i> <?= htmlspecialchars($offre['entreprise_nom']) ?></p>
            <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($offre['ville']) ?></p>
            <p><i class="fas fa-clock"></i> <?= htmlspecialchars($offre['duree']) ?></p>
            <p><i class="fas fa-tag"></i> <?= htmlspecialchars($offre['domaine']) ?></p>
            <div class="offer-card-footer">
                <a class="details-btn" href="<?= BASE_URL ?>offres/detail?id=<?= $offre['id'] ?>">Voir le détail</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>

<script>
// Retire la carte de la wishlist quand on clique sur le cœur depuis cette page
document.querySelectorAll('.wishlist-page .wishlist-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const offreId = this.dataset.offre;
        const card    = document.getElementById('wl-card-' + offreId);
        const fd      = new FormData();
        fd.append('offre_id', offreId);

        fetch('<?= BASE_URL ?>wishlist/toggle', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(function(data) {
                if (!data.in_wishlist && card) {
                    card.style.transition = 'opacity .3s';
                    card.style.opacity    = '0';
                    setTimeout(function() { card.remove(); }, 300);
                }
            });
    });
});
</script>
