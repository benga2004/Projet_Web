<?php 
$title = "Connexion - StageHub";
$content = "Connexion à StageHub";
require BASE_PATH . '/app/views/layout/header.php'; ?>


<h1>Connectez-Vous</h1>

<?php if (!empty($erreur)): ?>
    <p>⚠️ <?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form action="" method="POST">
    <fieldset>
        <div class="form-group">
            <label for="email">Adresse E-mail</label>
            <input type="email" id="email" name="email"
                value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required><br><br>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn-submit">Connexion</button>
    </fieldset>

</form>
<div class="login-section">
    <a href="#forgot">Mot de passe oublié ?</a>
    <p>Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
</div>

<?php require BASE_PATH . '/app/views/layout/footer.php';?>