<?php
session_start();
require_once('../config/config.php');

if (!isset($_SESSION['etudiant_id'])) {
    header('Location: login_etud.php');
    exit;
}

$connexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connexion->connect_error) {
    die("Erreur connexion : " . $connexion->connect_error);
}

// Récupérer tous les QCM disponibles
$requete = $connexion->query("SELECT ID_QCM, Titre_QCM FROM QCM");
$qcms = [];
while ($qcm = $requete->fetch_assoc()) {
    $qcms[] = $qcm;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Étudiant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bienvenue Étudiant <?php echo htmlspecialchars($_SESSION['etudiant_nom']); ?></h1>

    <h2>QCM Disponibles :</h2>

    <?php if (empty($qcms)): ?>
        <p>Aucun QCM disponible pour l’instant.</p>
    <?php else: ?>
    
            <?php foreach ($qcms as $qcm): ?>
            
                    <div class="qcm_case">
                     <?php echo htmlspecialchars($qcm['Titre_QCM']); ?>
                    - <a href="passer_qcm.php?id_qcm=<?php echo $qcm["ID_QCM"] ?>">Passer ce QCM</a>
                    </div>
            <?php endforeach; ?>
      
    <?php endif; ?>

    <br>
    <a href="logout.php"><div class="se-deconnecter">Se déconnecter</div></a>
<style>


body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f8;
    margin: 0;
    padding: 20px;
    color: #333;
}

h1 {
    color: #2c3e50;
}

h2 {
    margin-top: 40px;
    color: #34495e;
}

.qcm_case {
    background-color: #ffffff;
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    width:fit-content;
}

.qcm_case a {
    text-decoration: none;
    color: #3498db;
    font-weight: bold;
}

.qcm_case a:hover {
    text-decoration: underline;
    color: #2c80b4;
}

.se-deconnecter {
    display: inline-block;
    background-color: #e74c3c;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-align: center;
    margin-top: 30px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.se-deconnecter:hover {
    background-color: #c0392b;
}

</style>
</body>
</html>
