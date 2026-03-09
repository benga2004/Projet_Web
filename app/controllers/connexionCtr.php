<?php
session_start();

$users = [
    ['email' => 'etudiant@mail.com',    'password' => 'etudiant123',    'nom' => 'Bangaly Kaba'],
    ['email' => 'entreprise@mail.com',  'password' => 'entreprise123',  'nom' => 'NovaTech Solutions'],
    ['email' => 'admin@mail.com',       'password' => 'admin123',       'nom' => 'Administrateur'],
];

$erreur = '';

if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
    header('Location: offre_de_stage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = isset($_POST['email'])    ? trim($_POST['email'])    : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($email) || empty($password)) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $trouve = false;
        foreach ($users as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                $trouve = true;
                $_SESSION['connecte'] = true;
                $_SESSION['email']    = $user['email'];
                $_SESSION['nom']      = $user['nom'];
                header('Location: offre_de_stage.php');
                exit();
            }
        }
        if (!$trouve) {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}

require __DIR__ . '/../views/connexion.php';
?>