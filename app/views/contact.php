<?php
$title   = "Contact - StageHub";
$content = "Contactez l'équipe StageHub pour toute question ou demande d'information";
$succes  = false;
$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom']    ?? '');
    $email  = trim($_POST['email']  ?? '');
    $sujet  = trim($_POST['sujet']  ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$nom)                                        $erreurs[] = 'Votre nom est obligatoire.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))   $erreurs[] = 'Adresse email invalide.';
    if (!$sujet)                                      $erreurs[] = 'Veuillez choisir un sujet.';
    if (strlen($message) < 20)                        $erreurs[] = 'Votre message doit faire au moins 20 caractères.';

    if (empty($erreurs)) {
        // En production : mail($dest, $sujet, $message) ou un service SMTP
        $succes = true;
    }
}

require __DIR__ . '/layout/header.php';
?>

<div class="contact-page">

    <!-- Hero -->
    <div class="legal-hero">
        <div class="legal-hero-icon"><i class="fas fa-envelope-open-text" aria-hidden="true"></i></div>
        <h1>Contactez-nous</h1>
        <p>Une question, un problème ou une suggestion ? Notre équipe vous répond sous 48 h.</p>
    </div>

    <div class="contact-layout">

        <!-- Formulaire -->
        <div class="contact-form-card">

            <?php if ($succes): ?>
            <div class="contact-success" role="status">
                <i class="fas fa-check-circle"></i>
                <h2>Message envoyé !</h2>
                <p>Merci pour votre message. Nous vous répondrons dans les plus brefs délais.</p>
                <a href="<?= BASE_URL ?>" class="btn btn-primary">Retour à l'accueil</a>
            </div>
            <?php else: ?>

            <?php if (!empty($erreurs)): ?>
            <div class="contact-alert" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <ul>
                    <?php foreach ($erreurs as $e): ?>
                        <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form method="POST" action="" novalidate>
                <div class="contact-row">
                    <div class="form-group">
                        <label for="nom">Nom complet <span class="cand-required">*</span></label>
                        <input type="text" id="nom" name="nom"
                            placeholder="Votre nom"
                            value="<?= htmlspecialchars($_POST['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="cand-required">*</span></label>
                        <input type="email" id="email" name="email"
                            placeholder="votre@email.com"
                            value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sujet">Sujet <span class="cand-required">*</span></label>
                    <select id="sujet" name="sujet" required>
                        <option value="">-- Choisir un sujet --</option>
                        <option value="info"      <?= ($_POST['sujet'] ?? '') === 'info'      ? 'selected' : '' ?>>Demande d'information</option>
                        <option value="probleme"  <?= ($_POST['sujet'] ?? '') === 'probleme'  ? 'selected' : '' ?>>Signaler un problème</option>
                        <option value="partenariat" <?= ($_POST['sujet'] ?? '') === 'partenariat' ? 'selected' : '' ?>>Partenariat entreprise</option>
                        <option value="rgpd"      <?= ($_POST['sujet'] ?? '') === 'rgpd'      ? 'selected' : '' ?>>Données personnelles (RGPD)</option>
                        <option value="autre"     <?= ($_POST['sujet'] ?? '') === 'autre'     ? 'selected' : '' ?>>Autre</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Message <span class="cand-required">*</span></label>
                    <textarea id="message" name="message" rows="7"
                        placeholder="Décrivez votre demande en détail..."
                        required><?= htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i>&nbsp; Envoyer le message
                </button>
            </form>

            <?php endif; ?>
        </div>

        <!-- Infos de contact -->
        <aside class="contact-info-panel">
            <h2>Nos coordonnées</h2>

            <div class="contact-info-item">
                <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <strong>Adresse</strong>
                    <p>12 rue de l'Innovation<br>75008 Paris, France</p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <strong>Email</strong>
                    <p><a href="mailto:contact@stagehub.fr">contact@stagehub.fr</a></p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
                <div>
                    <strong>Téléphone</strong>
                    <p>01 23 45 67 89<br><small>Lun–Ven, 9h–18h</small></p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <strong>Délai de réponse</strong>
                    <p>Sous 48 heures ouvrées</p>
                </div>
            </div>

            <div class="contact-social">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </aside>

    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
