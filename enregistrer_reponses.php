<?php
session_start();
require_once('../config/config.php');

if (!isset($_SESSION['etudiant_id'])) {
    header('Location: login_etud.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_qcm']) || !isset($_POST['reponses'])) {
    header('Location: dashboard_etud.php');
    exit;
}

$connexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connexion->connect_error) {
    die("Erreur connexion : " . $connexion->connect_error);
}

$id_qcm = intval($_POST['id_qcm']);
$reponses_etudiant = $_POST['reponses'];

// Compter les bonnes réponses
$note = 0;
$total_questions = count($reponses_etudiant);

foreach ($reponses_etudiant as $id_question => $id_reponse_choisie) {
    $requete = $connexion->prepare("
        SELECT Est_Correct
        FROM Reponse
        WHERE ID_Reponse = ? AND ID_Question = ?
    ");
    $requete->bind_param("ii", $id_reponse_choisie, $id_question);
    $requete->execute();
    $resultat = $requete->get_result();
    if ($ligne = $resultat->fetch_assoc()) {
        if ($ligne['Est_Correct']) {
            $note++;
        }
        else{
            $note--;
        }
    }
}

// Calcul final de la note sur 100
$note_sur_100 = intval(($note / $total_questions) * 100);

// Enregistrer la note dans la table Resultat
$requete_inserer = $connexion->prepare("
    INSERT INTO Resultat (ID_Etud, ID_QCM, Note)
    VALUES (?, ?, ?)
");
$requete_inserer->bind_param("iii", $_SESSION['etudiant_id'], $id_qcm, $note_sur_100);
$requete_inserer->execute();

// Message de confirmation
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat du QCM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Merci d'avoir passé le QCM</h1>
    <p>Votre note : <strong><?php echo $note_sur_100; ?>/100</strong></p>

    <a href="dashboard_etud.php" class="link">Retour au tableau de bord</a>
<style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f4f8;
    margin: 0;
    padding: 30px;
    text-align: center;
}

h1 {
    color: #2c3e50;
    font-size: 32px;
    margin-bottom: 20px;
}

p {
    font-size: 20px;
    color: #34495e;
}

strong {
    font-size: 24px;
    color: #27ae60;
}

a.link {
    display: inline-block;
    margin-top: 30px;
    padding: 12px 20px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    transition: background-color 0.3s ease;
}

a.link:hover {
    background-color: #2980b9;
}

    </style>
</body>
</html>
