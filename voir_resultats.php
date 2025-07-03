<?php
session_start();
require_once('../config/config.php');

if (!isset($_SESSION['professeur_id'])) {
    header('Location: login_prof.php');
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$connexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connexion->connect_error) {
    die("Erreur connexion : " . $connexion->connect_error);
}

// Sélectionner résultats associés au professeur connecté
$requete = $connexion->prepare("
    SELECT QCM.Titre_QCM, Etudiant.Nom_Etud, Etudiant.Prenom_Etud, Resultat.Note, Resultat.Date_Passage
    FROM Resultat
    JOIN QCM ON Resultat.ID_QCM = QCM.ID_QCM
    JOIN Etudiant ON Resultat.ID_Etud = Etudiant.ID_Etud
    WHERE QCM.ID_Prof = ?
    ORDER BY Resultat.Date_Passage DESC
");
$requete->bind_param("i", $_SESSION['professeur_id']);
$requete->execute();
$resultats = $requete->get_result();

$donnees = $resultats ? $resultats->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats des Étudiants</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Résultats des étudiants pour vos QCM</h1>

    <?php if (empty($donnees)): ?>
        <p>Aucun résultat disponible pour l’instant.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>QCM</th>
                    <th>Étudiant</th>
                    <th>Note</th>
                    <th>Date de Passage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donnees as $resultat): ?>
                    <tr class="table">
                        <td><?php echo htmlspecialchars($resultat['Titre_QCM']); ?></td>
                        <td><?php echo htmlspecialchars($resultat['Nom_Etud'] . ' ' . $resultat['Prenom_Etud']); ?></td>
                        <td><?php echo htmlspecialchars($resultat['Note']); ?>/100</td>
                        <td><?php echo htmlspecialchars($resultat['Date_Passage']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <br>
    <a href="dashboard_prof.php">Retour au tableau de bord</a>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f8;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #333;
}

table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

table th, table td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #007BFF;
    color: white;
    text-transform: uppercase;
    font-size: 14px;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}

a {
    display: block;
    width: fit-content;
    margin: 30px auto;
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

a:hover {
    background-color: #0056b3;
}

    </style>
</body>
</html>
