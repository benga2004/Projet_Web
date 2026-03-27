<?php

$offres = [
    [
        'titre'      => 'Développeur Web',
        'entreprise' => 'Cesi École d\'Ingénieurs',
        'ville'      => 'Saint-Nazaire',
        'duree'      => '3 mois',
        'domaine'    => 'Développement Web',
        'description'=> 'Le CESI École d\'Ingénieurs recherche un stagiaire en développement web motivé pour rejoindre son équipe digitale...',
        'date'       => 'Publié il y a 2 jours',
    ],
    [
        'titre'      => 'Stage Marketing Digital',
        'entreprise' => 'BrandWave Agency',
        'ville'      => 'Lyon',
        'duree'      => '4 mois',
        'domaine'    => 'Marketing',
        'description'=> 'BrandWave Agency recherche un stagiaire en marketing digital pour gérer les réseaux sociaux et campagnes SEA.',
        'date'       => 'Publié il y a 3 jours',
    ],
    [
        'titre'      => 'Ingénieur Automatisme',
        'entreprise' => 'IndusTrial Group',
        'ville'      => 'Nantes',
        'duree'      => '6 mois',
        'domaine'    => 'Industrie',
        'description'=> 'IndusTrial Group recherche un stagiaire pour le développement de programmes PLC et mise en service de lignes de production.',
        'date'       => 'Publié il y a 4 jours',
    ],
    [
        'titre'      => 'UI/UX Designer',
        'entreprise' => 'Pixel Studio',
        'ville'      => 'Bordeaux',
        'duree'      => '3 mois',
        'domaine'    => 'Design',
        'description'=> 'Pixel Studio cherche un stagiaire pour concevoir des maquettes Figma et participer aux tests utilisateurs.',
        'date'       => 'Publié il y a 5 jours',
    ],
    [
        'titre'      => 'Développeur Back-end PHP',
        'entreprise' => 'NovaTech Solutions',
        'ville'      => 'Paris',
        'duree'      => '3 mois',
        'domaine'    => 'Développement Web',
        'description'=> 'NovaTech Solutions recherche un stagiaire back-end PHP pour travailler sur des APIs REST et bases de données MySQL.',
        'date'       => 'Publié il y a 6 jours',
    ],
    [
        'titre'      => 'Data Analyst',
        'entreprise' => 'DataSphere',
        'ville'      => 'Paris',
        'duree'      => '4 mois',
        'domaine'    => 'Informatique',
        'description'=> 'DataSphere cherche un stagiaire pour exploiter des datasets avec Python/Pandas et créer des dashboards Power BI.',
        'date'       => 'Publié il y a 1 semaine',
    ],
];

// ── Récupération des paramètres de recherche ──────────────
$recherche = isset($_GET['search']) ? trim($_GET['search']) : '';
$filtre    = isset($_GET['filter']) ? trim($_GET['filter']) : 'all';
$valeur    = isset($_GET['valeur']) ? trim(strtolower($_GET['valeur'])) : '';

// ── Filtrage des offres ───────────────────────────────────
$resultats = array_filter($offres, function($offre) use ($recherche, $filtre, $valeur) {

    // Recherche textuelle libre (titre, entreprise, domaine, ville)
    if (!empty($recherche)) {
        $r = strtolower($recherche);
        $haystack = strtolower($offre['titre'] . ' ' . $offre['entreprise'] . ' ' . $offre['domaine'] . ' ' . $offre['ville']);
        if (strpos($haystack, $r) === false) return false;
    }

    // Filtre par catégorie + valeur
    if ($filtre !== 'all' && !empty($valeur)) {
        switch ($filtre) {
            case 'company':
                if (strpos(strtolower($offre['entreprise']), $valeur) === false) return false;
                break;
            case 'cities':
                if (strpos(strtolower($offre['ville']), $valeur) === false) return false;
                break;
            case 'duration':
                if (strpos(strtolower($offre['duree']), $valeur) === false) return false;
                break;
            case 'field':
                if (strpos(strtolower($offre['domaine']), $valeur) === false) return false;
                break;
        }
    }

    return true;
});

?>
<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="../css/offre_de_stage.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <nav>
        <a href="../Projet_Web/detail_d'offre.html">details</a>
    </nav>
    <title>Offres de stage</title>
</head>
<body>

<header>
    <img src="Image/Logo.png" width="100">
    <button aria-label="Menu">☰</button>
</header>

<h1>Offres de stage</h1>

<center>
    <section id="search-bar">

        <form method="GET" action="">

            <label for="search"></label>
            <input type="search" id="search" name="search"
                placeholder="Rechercher une offre de stage, une entreprise..."
                value="<?= htmlspecialchars($recherche, ENT_QUOTES, 'UTF-8') ?>">
            <br>

            <label for="filter"></label>
            <select id="filter" name="filter">
                <option value="all"      <?= $filtre === 'all'      ? 'selected' : '' ?>>Filtrer</option>
                <option value="company"  <?= $filtre === 'company'  ? 'selected' : '' ?>>Entreprise</option>
                <option value="cities"   <?= $filtre === 'cities'   ? 'selected' : '' ?>>Ville</option>
                <option value="duration" <?= $filtre === 'duration' ? 'selected' : '' ?>>Durée</option>
                <option value="field"    <?= $filtre === 'field'    ? 'selected' : '' ?>>Domaine</option>
            </select>

            <!-- Champ valeur qui apparaît si un filtre est sélectionné -->
            <span id="valeur-wrap" <?= $filtre === 'all' ? 'style="display:none"' : '' ?>>
                <input type="text" id="valeur" name="valeur"
                    placeholder="Valeur du filtre..."
                    value="<?= htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8') ?>">
            </span>

            <input type="submit" id="filter-btn" value="Rechercher">

        </form>

    </section>
</center>

<!-- Nombre de résultats -->
<p><?= count($resultats) ?> offre(s) trouvée(s)
<?php if (!empty($recherche)): ?>
    pour "<strong><?= htmlspecialchars($recherche, ENT_QUOTES, 'UTF-8') ?></strong>"
<?php endif; ?>
</p>

<!-- Affichage des offres filtrées -->
<?php if (empty($resultats)): ?>
    <p>Aucune offre ne correspond à votre recherche.</p>
<?php else: ?>
    <?php foreach ($resultats as $index => $offre): ?>
        <section class="offer">
            <h2><?= htmlspecialchars($offre['titre'],       ENT_QUOTES, 'UTF-8') ?></h2>
            <h3><?= htmlspecialchars($offre['entreprise'],  ENT_QUOTES, 'UTF-8') ?></h3>

            <p><strong>Ville :</strong>   <?= htmlspecialchars($offre['ville'],   ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Durée :</strong>   <?= htmlspecialchars($offre['duree'],   ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Domaine :</strong> <?= htmlspecialchars($offre['domaine'], ENT_QUOTES, 'UTF-8') ?></p>

            <p><?= htmlspecialchars($offre['description'], ENT_QUOTES, 'UTF-8') ?></p>

            <p class="date"><?= htmlspecialchars($offre['date'], ENT_QUOTES, 'UTF-8') ?></p>

            <label for="details">Voir les détails :</label>
           <a href="detail_d'offre.php?id=<?= $index ?>">Détails</a>
        </section>
    <?php endforeach; ?>
<?php endif; ?>

<script>
    // Affiche/cache le champ valeur selon le filtre choisi
    document.getElementById('filter').addEventListener('change', function () {
        const wrap = document.getElementById('valeur-wrap');
        wrap.style.display = this.value === 'all' ? 'none' : 'inline';
    });
</script>

</body>
</html>