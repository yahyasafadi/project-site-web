<?php
session_start();
require_once('../config/config.php');

if (!isset($_SESSION['etudiant_id'])) {
    header('Location: login_etud.php');
    exit;
}

if (!isset($_GET['id_qcm'])) {
    header('Location: dashboard_etud.php');
    exit;
}

$id_qcm = intval($_GET['id_qcm']);
$connexion=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connexion->connect_error) {
    die("Erreur connexion : " . $connexion->connect_error);
}

$requete = $connexion->prepare("
    SELECT Question.ID_Question, Question.Texte_Question, Reponse.ID_Reponse, Reponse.Texte_Reponse
    FROM Question
    INNER JOIN Reponse ON Question.ID_Question = Reponse.ID_Question
    WHERE Question.ID_QCM = ?
    ORDER BY Question.ID_Question
");
$requete->bind_param("i", $id_qcm);
$requete->execute();
$resultat = $requete->get_result();

$questions = [];
while ($ligne = $resultat->fetch_assoc()) {
    $questions[$ligne['ID_Question']]['texte'] = $ligne['Texte_Question'];
    $questions[$ligne['ID_Question']]['reponses'][] = [
        'id_reponse' => $ligne['ID_Reponse'],
        'texte_reponse' => $ligne['Texte_Reponse']
    ];
}

if (empty($questions)) {
    echo "Aucune question disponible pour ce QCM.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Passer le QCM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Passer le QCM</h1>

    <form method="POST" action="enregistrer_reponses.php">
        <?php foreach ($questions as $id_question => $donnees): ?>
            <div style="margin-bottom: 20px;">
                <strong><?php echo htmlspecialchars($donnees['texte']); ?></strong><br>

                <?php foreach ($donnees['reponses'] as $reponse): ?>
                    <input type="radio" name="reponses[<?php echo $id_question; ?>]" value="<?php echo $reponse['id_reponse']; ?>" required>
                    <?php echo htmlspecialchars($reponse['texte_reponse']); ?><br>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <input type="hidden" name="id_qcm" value="<?php echo $id_qcm; ?>">
        <button type="submit">Soumettre mes réponses</button>
    </form>

    <br>
    <a href="dashboard_etud.php">Retour au tableau de bord</a>
    <style>
       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9fbfd;
    padding: 20px;
    margin: 0;
    }

h1 {
    text-align: center;
    background-color: #2c3e50;
    color: white;
    padding: 20px 0;
    margin-bottom: 30px;
}

form {
    max-width: 800px;
    margin: auto;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

div[style*="margin-bottom"] {
    padding: 15px;
    border: 1px solid #e1e4e8;
    border-radius: 8px;
    margin-bottom: 20px;
    background-color: #f5f7fa;
}

strong {
    display: block;
    font-size: 18px;
    margin-bottom: 10px;
    color: #2c3e50;
}

input[type="radio"] {
    margin-right: 10px;
}

button[type="submit"] {
    background-color: #27ae60;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    display: block;
    margin: 20px auto;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #219150;
}

a {
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    color: #2980b9;
}

a:hover {
    text-decoration: underline;
}

    </style>
</body>
</html>
