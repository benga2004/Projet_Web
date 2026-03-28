<?php
$title     = "Dashboard Pilote - StageHub";
$extra_css = '<link rel="stylesheet" href="' . BASE_URL . 'css/dashboard-pilote.css?v=2">' . "\n"
           . '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">';
include __DIR__ . '/../layout/header.php';
?>

<?php /* données injectées par PiloteController */ ?>

<h1>Dashboard Pilote</h1>

<!-- HERO -->
<div class="hero">
    <div style="font-size:11px; color:#40c057; font-weight:700; margin-bottom:6px;">
        <i class="bi bi-circle-fill" style="font-size:8px;"></i> Session active
    </div>
    <p class="hero-sub">Pilote · <?= htmlspecialchars($pilote['prenom'] . ' ' . $pilote['nom'], ENT_QUOTES, 'UTF-8') ?></p>
    <span class="hero-badge">PILOTE DE PROMOTION</span>
</div>

<!-- STATS -->
<div class="stats-grid">
    <?php foreach ($stats as $s): ?>
        <div class="stat-card <?= $s['cls'] ?>">
            <div><?= $s['icon'] ?></div>
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
        <button type="submit" class="btn-submit"><i class="bi bi-search"></i> Rechercher</button>
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
        <button type="button" class="btn-ghost"><i class="bi bi-file-earmark-person"></i> CV</button>
                    <button type="button" class="btn-ghost"><i class="bi bi-file-earmark-text"></i> LM</button>
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