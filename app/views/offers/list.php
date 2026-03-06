<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Offres</title>

<link rel="stylesheet" href="../css/inscription.css">
<link rel="stylesheet" href="../css/offres.css">

</head>

<body>

<div class="phone-frame">

<header class="header">

<div class="logo">
<div class="logo-icon">Logo</div>
<span>StageHub</span>
</div>

</header>

<main class="content">

<h1>Offres de stage</h1>

<p class="info">
<?= $total ?> offres disponibles
</p>

<?php foreach ($offresPage as $offre): ?>

<div class="offer-card">

<h2><?= htmlspecialchars($offre['titre']) ?></h2>

<p class="company"><?= htmlspecialchars($offre['entreprise']) ?></p>

<p>Ville : <?= htmlspecialchars($offre['ville']) ?></p>

<p>Durée : <?= htmlspecialchars($offre['duree']) ?></p>

<p>Domaine : <?= htmlspecialchars($offre['domaine']) ?></p>

<button class="btn-submit">Détails</button>

</div>

<?php endforeach; ?>

</main>

</div>

</body>

</html>