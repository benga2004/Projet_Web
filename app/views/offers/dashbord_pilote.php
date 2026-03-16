<?php $title = "Dashboard Pilote - StageHub"; ?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<link rel="stylesheet" href="/public/css/style.css">
<link rel="stylesheet" href="/public/css/dashboard-pilote.css">

<?php
// ============================================
// DONNÉES DU PILOTE (à remplacer par BDD)
// ============================================

$pilote = [
    'nom'   => 'Jeremy Gallet',
    'promo' => 'A2 INFO',
];

$stats = [
    ['icon' => '🎓', 'val' => 24, 'lbl' => 'Étudiants',   'delta' => 'Promo ' . $pilote['promo'], 'color' => 'var(--primary)', 'cls' => 'c1'],
    ['icon' => '✅', 'val' => 4,  'lbl' => 'Stages',       'delta' => '1 ce mois',                 'color' => '#40c057',        'cls' => 'c2'],
    ['icon' => '📨', 'val' => 38, 'lbl' => 'Candidatures', 'delta' => '5 cette semaine',           'color' => '#fd7e14',        'cls' => 'c3'],
    ['icon' => '⚠️', 'val' => 4,  'lbl' => 'Sans cand.',   'delta' => 'À relancer',                'color' => '#fa5252',        'cls' => 'c4'],
];

$etudiants = [
    ['initiale' => 'A', 'nom' => 'Alice Martin', 'cand' => 3, 'badge' => 'badge-orange', 'statut' => 'En recherche'],
    ['initiale' => 'B', 'nom' => 'Bob Leroy',    'cand' => 1, 'badge' => 'badge-green',  'statut' => 'Stage trouvé'],
    ['initiale' => 'C', 'nom' => 'Clara Petit',  'cand' => 2, 'badge' => 'badge-orange', 'statut' => 'En recherche'],
    ['initiale' => 'D', 'nom' => 'David Simon',  'cand' => 0, 'badge' => 'badge-red',    'statut' => 'Sans candidature'],
];

$barres = [
    ['lbl' => 'Stages trouvés',   'val' => '4/24',  'pct' => 17, 'color' => '#38a169'],
    ['lbl' => 'En recherche',     'val' => '16/24', 'pct' => 67, 'color' => 'var(--primary)'],
    ['lbl' => 'Sans candidature', 'val' => '4/24',  'pct' => 16, 'color' => '#e53e3e'],
];

$candidatures = [
    ['initiale' => 'A', 'nom' => 'Alice Martin', 'poste' => 'Dev PHP', 'entreprise' => 'Capgemini', 'date' => '2025-03-01', 'badge' => 'badge-orange', 'statut' => 'En attente'],
    ['initiale' => 'B', 'nom' => 'Bob Leroy',    'poste' => 'DevOps',  'entreprise' => 'Airbus',    'date' => '2025-02-15', 'badge' => 'badge-green',  'statut' => 'Acceptée'],
    ['initiale' => 'C', 'nom' => 'Clara Petit',  'poste' => 'Data',    'entreprise' => 'Thales',    'date' => '2025-03-10', 'badge' => 'badge-orange', 'statut' => 'En attente'],
];

$activites = [
    ['dot' => '#38a169', 'txt' => '✅ Bob a trouvé son stage – Airbus',  'time' => 'il y a 1h'],
    ['dot' => '#6b5bcd', 'txt' => '📨 Alice a postulé chez Capgemini',   'time' => 'il y a 3h'],
    ['dot' => '#d97706', 'txt' => "⚠️ David n'a aucune candidature",     'time' => 'il y a 5h'],
    ['dot' => '#7a7a9d', 'txt' => '🏢 Nouvelle offre – Thales Lyon',     'time' => 'il y a 1j'],
];
?>

<h1>Dashboard Pilote</h1>

<!-- HERO -->
<div class="hero">
    <div style="font-size:11px; color:#40c057; font-weight:700; margin-bottom:6px;">
        <span class="hero-dot"></span>Session active
    </div>
    <p class="hero-sub">Pilote · Promotion <?= htmlspecialchars($pilote['promo']) ?></p>
    <span class="hero-badge">PILOTE DE PROMOTION</span>
</div>

<!-- STATS -->
<div class="stats-grid">
    <?php foreach ($stats as $s): ?>
        <div class="stat-card <?= $s['cls'] ?>">
            <div class="stat-icon"><?= $s['icon'] ?></div>
            <div class="stat-val"><?= $s['val'] ?></div>
            <div class="stat-lbl"><?= htmlspecialchars($s['lbl']) ?></div>
            <div class="stat-delta" style="color:<?= $s['color'] ?>">
                <?= htmlspecialchars($s['delta']) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- SUIVI ÉTUDIANTS -->
<div class="card">
    <div class="card-head">
        <span class="card-title">Suivi étudiants</span>
        <a href="#" class="see-all">Voir tous →</a>
    </div>

    <?php foreach ($etudiants as $e): ?>
        <div class="row">
            <div style="display:flex; align-items:center; gap:8px;">
                <div class="avatar"><?= htmlspecialchars($e['initiale']) ?></div>
                <div>
                    <div style="font-weight:600; font-size:12px;"><?= htmlspecialchars($e['nom']) ?></div>
                    <div style="color:var(--muted); font-size:10px;">
                        <?= $e['cand'] ?> candidature<?= $e['cand'] > 1 ? 's' : '' ?>
                    </div>
                </div>
            </div>
            <span class="badge <?= $e['badge'] ?>"><?= htmlspecialchars($e['statut']) ?></span>
        </div>
    <?php endforeach; ?>
</div>

<!-- GRAPHIQUE -->
<div class="card">
    <div class="card-head">
        <span class="card-title">Candidatures / mois</span>
        <span class="badge badge-purple">2024–25</span>
    </div>
    <div class="chart-wrap">
        <?php foreach ([25, 46, 36, 66, 57, 100] as $h): ?>
            <div class="chart-bar" style="height:<?= $h ?>%"></div>
        <?php endforeach; ?>
    </div>
    <div class="chart-labels">
        <?php foreach (['Oct','Nov','Déc','Jan','Fév','Mar'] as $m): ?>
            <span><?= $m ?></span>
        <?php endforeach; ?>
    </div>
    <div style="margin-top:14px;">
        <?php foreach ($barres as $b): ?>
            <div class="bar-wrap">
                <div class="bar-label">
                    <span><?= htmlspecialchars($b['lbl']) ?></span>
                    <span style="font-weight:700; color:<?= $b['color'] ?>"><?= $b['val'] ?></span>
                </div>
                <div class="bar-track">
                    <div class="bar-fill" style="width:<?= $b['pct'] ?>%; background:<?= $b['color'] ?>;"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- CANDIDATURES RÉCENTES -->
<div class="card">
    <div class="card-head">
        <span class="card-title">Candidatures récentes</span>
        <a href="#" class="see-all">Voir toutes →</a>
    </div>

    <fieldset>
        <legend class="sr-only">Rechercher une candidature</legend>
        <div class="form-group">
            <label for="search">Rechercher</label>
            <input type="text" id="search" name="search" placeholder="Étudiant, entreprise…">
        </div>
        <button type="submit" class="btn-submit">🔍 Rechercher</button>
    </fieldset>

    <?php foreach ($candidatures as $c): ?>
        <div class="cand-row">
            <div style="display:flex; align-items:center; gap:10px;">
                <div class="avatar"><?= htmlspecialchars($c['initiale']) ?></div>
                <div>
                    <div style="font-weight:700; font-size:12px;"><?= htmlspecialchars($c['nom']) ?></div>
                    <div class="company"><?= htmlspecialchars($c['poste']) ?> · <?= htmlspecialchars($c['entreprise']) ?></div>
                    <div style="color:var(--muted); font-size:10px;">📅 <?= htmlspecialchars($c['date']) ?></div>
                </div>
            </div>
            <div style="display:flex; flex-direction:column; align-items:flex-end; gap:5px;">
                <span class="badge <?= $c['badge'] ?>"><?= htmlspecialchars($c['statut']) ?></span>
                <div style="display:flex; gap:4px;">
                    <button class="btn-ghost">📄 CV</button>
                    <button class="btn-ghost">✉️ LM</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- ACTIVITÉ RÉCENTE -->
<div class="card">
    <div class="card-head">
        <span class="card-title">Activité récente</span>
    </div>
    <?php foreach ($activites as $a): ?>
        <div class="act">
            <div class="act-dot" style="background:<?= $a['dot'] ?>;"></div>
            <div>
                <div><?= htmlspecialchars($a['txt']) ?></div>
                <div style="color:var(--muted); margin-top:2px;"><?= htmlspecialchars($a['time']) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>