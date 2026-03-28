<?php
$prenom = htmlspecialchars($user['prenom'] ?? $_SESSION['user_prenom'] ?? '', ENT_QUOTES, 'UTF-8');
$nom    = htmlspecialchars($user['nom']    ?? '', ENT_QUOTES, 'UTF-8');
$email  = htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8');
$initiales = strtoupper(substr($prenom, 0, 1) . substr($nom, 0, 1));

$nbCandidatures = count($candidatures ?? []);
$nbWishlist     = count($wishlistOffres ?? []);
$nbAcceptees    = count(array_filter($candidatures ?? [], fn($c) => $c['statut'] === 'acceptee'));
?>

<div class="dash-wrap">

    <!-- ── Sidebar ── -->
    <aside class="dash-sidebar">
        <div class="dash-avatar"><?= $initiales ?></div>
        <p class="dash-name"><?= $prenom ?> <?= $nom ?></p>
        <p class="dash-role"><i class="fas fa-graduation-cap"></i> Étudiant</p>
        <p class="dash-email"><i class="fas fa-envelope"></i> <?= $email ?></p>

        <nav class="dash-nav">
            <a href="#profil"       class="dash-nav-link active" data-tab="profil">
                <i class="fas fa-user"></i> Mon Profil
            </a>
            <a href="#candidatures" class="dash-nav-link" data-tab="candidatures">
                <i class="fas fa-paper-plane"></i> Candidatures
                <span class="dash-badge"><?= $nbCandidatures ?></span>
            </a>
            <a href="#wishlist"     class="dash-nav-link" data-tab="wishlist">
                <i class="fas fa-bookmark"></i> Wishlist
                <span class="dash-badge"><?= $nbWishlist ?></span>
            </a>
            <a href="#modifier"    class="dash-nav-link" data-tab="modifier">
                <i class="fas fa-pen"></i> Modifier le profil
            </a>
        </nav>

        <a class="dash-logout" href="<?= BASE_URL ?>deconnexion">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </aside>

    <!-- ── Main ── -->
    <main class="dash-main">

        <!-- Stat cards -->
        <div class="dash-stats">
            <div class="dash-stat-card">
                <div class="dash-stat-icon bg-blue"><i class="fas fa-paper-plane"></i></div>
                <div>
                    <p class="dash-stat-value"><?= $nbCandidatures ?></p>
                    <p class="dash-stat-label">Candidatures</p>
                </div>
            </div>
            <div class="dash-stat-card">
                <div class="dash-stat-icon bg-green"><i class="fas fa-check-circle"></i></div>
                <div>
                    <p class="dash-stat-value"><?= $nbAcceptees ?></p>
                    <p class="dash-stat-label">Acceptées</p>
                </div>
            </div>
            <div class="dash-stat-card">
                <div class="dash-stat-icon bg-purple"><i class="fas fa-bookmark"></i></div>
                <div>
                    <p class="dash-stat-value"><?= $nbWishlist ?></p>
                    <p class="dash-stat-label">Sauvegardées</p>
                </div>
            </div>
        </div>

        <!-- ── Tab: Profil ── -->
        <div class="dash-tab active" id="tab-profil">
            <div class="dash-card">
                <h2 class="dash-card-title"><i class="fas fa-user-circle"></i> Informations personnelles</h2>
                <div class="info-row"><span class="label">Prénom</span><span><?= $prenom ?></span></div>
                <div class="info-row"><span class="label">Nom</span><span><?= $nom ?></span></div>
                <div class="info-row"><span class="label">Email</span><span><?= $email ?></span></div>
                <div class="info-row"><span class="label">Rôle</span><span>Étudiant</span></div>
                <div class="info-row"><span class="label">Mon CV</span><span>
                    <?php if (!empty($user['cv_path'])): ?>
                        <a href="<?= BASE_URL . htmlspecialchars($user['cv_path'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="dash-cv-link">
                            <i class="fas fa-file-pdf"></i> Voir mon CV
                        </a>
                    <?php else: ?>
                        <span style="color:#718096">Aucun CV enregistré</span>
                    <?php endif; ?>
                </span></div>
            </div>
            <div class="dash-card">
                <h2 class="dash-card-title"><i class="fas fa-search"></i> Trouver un stage</h2>
                <p style="color:#718096;margin-bottom:16px">Parcourez toutes les offres disponibles et postulez directement.</p>
                <a href="<?= BASE_URL ?>offres" class="btn btn-primary">
                    <i class="fas fa-briefcase"></i> Voir les offres
                </a>
            </div>
        </div>

        <!-- ── Tab: Candidatures ── -->
        <div class="dash-tab" id="tab-candidatures">
            <div class="dash-card">
                <h2 class="dash-card-title"><i class="fas fa-paper-plane"></i> Mes candidatures</h2>
                <?php if (empty($candidatures)): ?>
                <div class="dash-empty">
                    <i class="fas fa-inbox"></i>
                    <p>Aucune candidature pour l'instant.</p>
                    <a href="<?= BASE_URL ?>offres" class="btn btn-primary">Parcourir les offres</a>
                </div>
                <?php else: ?>
                <div class="dash-table-wrap">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Offre</th>
                            <th>Entreprise</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($candidatures as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['offre_titre']) ?></td>
                            <td><?= htmlspecialchars($c['entreprise_nom']) ?></td>
                            <td><?= date('d/m/Y', strtotime($c['created_at'])) ?></td>
                            <td>
                                <?php
                                $st = $c['statut'];
                                $map = ['en_attente' => ['badge-orange','En attente'], 'acceptee' => ['badge-green','Acceptée'], 'refusee' => ['badge-red','Refusée']];
                                [$cls, $lbl] = $map[$st] ?? ['badge-orange','—'];
                                ?>
                                <span class="dash-badge-status <?= $cls ?>"><?= $lbl ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ── Tab: Wishlist ── -->
        <div class="dash-tab" id="tab-wishlist">
            <div class="dash-card">
                <h2 class="dash-card-title"><i class="fas fa-bookmark"></i> Ma Wishlist</h2>
                <?php if (empty($wishlistOffres)): ?>
                <div class="dash-empty">
                    <i class="fas fa-bookmark"></i>
                    <p>Aucune offre sauvegardée.</p>
                    <a href="<?= BASE_URL ?>offres" class="btn btn-primary">Parcourir les offres</a>
                </div>
                <?php else: ?>
                <div class="dash-wl-grid">
                    <?php foreach ($wishlistOffres as $offre): ?>
                    <div class="dash-wl-card" id="wl-card-<?= $offre['id'] ?>">
                        <div class="dash-wl-header">
                            <strong><?= htmlspecialchars($offre['titre']) ?></strong>
                            <button class="wishlist-btn active" type="button"
                                    data-offre="<?= $offre['id'] ?>"
                                    title="Retirer de la wishlist">
                                <i class="fas fa-bookmark"></i>
                            </button>
                        </div>
                        <p><i class="fas fa-building"></i> <?= htmlspecialchars($offre['entreprise_nom']) ?></p>
                        <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($offre['ville']) ?></p>
                        <p><i class="fas fa-clock"></i> <?= htmlspecialchars($offre['duree']) ?></p>
                        <a href="<?= BASE_URL ?>offres/detail?id=<?= $offre['id'] ?>" class="btn btn-primary btn-sm">
                            Voir le détail
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ── Tab: Modifier le profil ── -->
        <div class="dash-tab" id="tab-modifier">
            <div class="dash-card">
                <h2 class="dash-card-title"><i class="fas fa-pen"></i> Modifier mon profil</h2>

                <?php if (!empty($succes_profil)): ?>
                <div class="dash-alert dash-alert--success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($succes_profil, ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($erreur_profil)): ?>
                <div class="dash-alert dash-alert--error">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($erreur_profil, ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data" class="dash-edit-form">
                    <input type="hidden" name="action" value="update_profil">

                    <div class="dash-form-row">
                        <div class="form-group">
                            <label for="edit-prenom">Prénom</label>
                            <input type="text" id="edit-prenom" name="prenom"
                                value="<?= htmlspecialchars($_POST['prenom'] ?? $user['prenom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-nom">Nom</label>
                            <input type="text" id="edit-nom" name="nom"
                                value="<?= htmlspecialchars($_POST['nom'] ?? $user['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit-email">Adresse email</label>
                        <input type="email" id="edit-email" name="email"
                            value="<?= htmlspecialchars($_POST['email'] ?? $user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <hr class="dash-divider">
                    <p class="dash-hint"><i class="fas fa-file-pdf"></i> Mon CV (PDF — 3 Mo max)</p>

                    <?php if (!empty($user['cv_path'])): ?>
                    <div class="dash-cv-current">
                        <i class="fas fa-check-circle" style="color:#68d391"></i>
                        <span>CV enregistré</span>
                        <a href="<?= BASE_URL . htmlspecialchars($user['cv_path'], ENT_QUOTES, 'UTF-8') ?>"
                           target="_blank" class="dash-cv-link">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="cv_profile"><?= !empty($user['cv_path']) ? 'Remplacer mon CV' : 'Ajouter mon CV' ?></label>
                        <div class="cand-file-drop">
                            <i class="fas fa-cloud-upload-alt cand-file-icon" aria-hidden="true"></i>
                            <span class="cand-file-label">Glissez votre PDF ici ou <span class="cand-file-browse">parcourez</span></span>
                            <input type="file" id="cv_profile" name="cv_profile" accept=".pdf">
                        </div>
                    </div>

                    <hr class="dash-divider">
                    <p class="dash-hint"><i class="fas fa-lock"></i> Laissez vide pour conserver votre mot de passe actuel</p>
                    <div class="dash-form-row">
                        <div class="form-group">
                            <label for="edit-password">Nouveau mot de passe</label>
                            <input type="password" id="edit-password" name="password" placeholder="8 caractères min">
                        </div>
                        <div class="form-group">
                            <label for="edit-password-confirm">Confirmer</label>
                            <input type="password" id="edit-password-confirm" name="password_confirm">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>

    </main>
</div>

<?php /* ─────────── Tab Modifier (injecté hors du main pour éviter les problèmes de layout) ─────────── */ ?>
<script>
// Ouvrir directement l'onglet modifier si le controller a signalé succes/erreur
<?php if (!empty($succes_profil) || !empty($erreur_profil)): ?>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('[data-tab="modifier"]')?.click();
});
<?php endif; ?>
</script>

<script>
// Onglets dashboard profil
document.querySelectorAll('.dash-nav-link').forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const tab = this.dataset.tab;
        document.querySelectorAll('.dash-nav-link').forEach(l => l.classList.remove('active'));
        document.querySelectorAll('.dash-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('tab-' + tab).classList.add('active');
    });
});

// Retrait wishlist depuis le profil (retire la carte sans rechargement)
document.querySelectorAll('.dash-wl-card .wishlist-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const offreId = this.dataset.offre;
        const card    = document.getElementById('wl-card-' + offreId);
        const fd      = new FormData();
        fd.append('offre_id', offreId);
        fetch((window.BASE_URL || '/') + 'wishlist/toggle', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(function(data) {
                if (!data.in_wishlist && card) {
                    card.style.transition = 'opacity .3s';
                    card.style.opacity    = '0';
                    setTimeout(() => card.remove(), 300);
                }
            });
    });
});
</script>