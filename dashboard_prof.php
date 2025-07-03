<?php
session_start();
require_once('../config/config.php');

if (!isset($_SESSION['professeur_id'])) {
    header('Location: login_prof.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Professeur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bienvenue Professeur <?php echo htmlspecialchars($_SESSION['professeur_nom']); ?></h1>

    <h2>Actions disponibles :</h2>
    <ul class="options">
        <li><a href="creer_qcm.php">Créer un nouveau QCM</a></li>
        <li><a href="voir_resultats.php">Voir les résultats des étudiants</a></li>
        <li><a href="creer_compte_etudiant.php">creer compte etudiant</a></li>
        <li><a href="logout.php">Se déconnecter</a></li>
    </ul>
<style>

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f7fa;
    margin: 0;
    padding: 0;
    text-align: center;
}

h1 {
    background-color: #34495e;
    color: white;
    padding: 20px 0;
    margin: 0;
}

h2 {
    color: #2c3e50;
    margin-top: 30px;
}

ul.options {
    list-style: none;
    padding: 0;
    margin: 30px auto;
    max-width: 400px;
}

ul.options li {
    background-color: #ecf0f1;
    border: 1px solid #bdc3c7;
    border-radius: 8px;
    margin: 15px 0;
    padding: 15px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

ul.options li:hover {
    transform: translateY(-3px);
}

ul.options a {
    text-decoration: none;
    color: #2c3e50;
    font-weight: bold;
    display: block;
    transition: color 0.3s;
}

ul.options a:hover {
    color: #2980b9;
}

</style>
</body>
</html>
