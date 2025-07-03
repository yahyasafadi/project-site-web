<?php
session_start();
require_once('../config/config.php');

if (!isset($_SESSION['professeur_id'])) {
    header('Location: login_prof.php');
    exit;
}

$connexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connexion->connect_error) {
    die("Erreur connexion : " . $connexion->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre_qcm = $_POST['titre_qcm'];
    $questions = $_POST['questions'];
    $reponses = $_POST['reponses'];
    $bonnes_reponses = $_POST['bonnes_reponses'];

    $requete_qcm = $connexion->prepare("INSERT INTO QCM (Titre_QCM, ID_Prof) VALUES (?, ?)");
    $requete_qcm->bind_param("si", $titre_qcm, $_SESSION['professeur_id']);
    $requete_qcm->execute();
    $id_qcm = $connexion->insert_id;

    foreach ($questions as $index => $texte_question) {
        if (trim($texte_question) == '') continue;
        
        $requete_question = $connexion->prepare("INSERT INTO Question (ID_QCM, Texte_Question) VALUES (?, ?)");
        $requete_question->bind_param("ici",$id_question,$texte_question);
        $requete_question->execute();
        $id_question = $connexion->insert_id;

        foreach ($repenses[$index] as $idx=>$text_repense) {
            $est_correct = $idx==$bonnes_reponses["index"]? 1 :0;
            $requete_reponse = $connexion->prepare("INSERT INTO Reponse (ID_Question, Texte_Reponse, Est_Correct) VALUES (?, ?, ?)");
            $requete_reponse->bind_param("isi", $id_question, $texte_reponse, $est_correct);
            $requete_reponse->execute();
        }
    }

    $message = "QCM créé avec succès.";
}
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un QCM</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Créer un nouveau QCM</h1>

    <?php if ($message): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Titre du QCM :</label><br>
        <input type="text" name="titre_qcm" required><br><br>

        <div id="questions-container">
            <div class="question-block">
                <label>Question :</label><br>
                <input type="text" name="questions[]" required><br>

                <label>Réponses :</label><br>
                <input type="text" name="reponses[0][]" required><br>
                <input type="text" name="reponses[0][]" required><br>
                <input type="text" name="reponses[0][]" required><br>
                <input type="text" name="reponses[0][]" required><br>

                <label>Indice de la bonne réponse (0-3) :</label><br>
                <input type="number" name="bonnes_reponses[]" min="0" max="3" required><br><br>
            </div>
        </div>

        <button type="button" onclick="ajouterQuestion()">Ajouter une question</button><br><br>

        <button type="submit">Créer le QCM</button>
    </form>

    <a href="dashboard_prof.php">Retour au tableau de bord</a>

    <script>
        let compteurQuestions = 1;

        function ajouterQuestion() {
            const container = document.getElementById('questions-container');

            const bloc = document.createElement('div');
            bloc.className = 'question-block';
            bloc.innerHTML = `
                <label>Question :</label><br>
                <input type="text" name="questions[]" required><br>

                <label>Réponses :</label><br>
                <input type="text" name="reponses[${compteurQuestions}][]" required><br>
                <input type="text" name="reponses[${compteurQuestions}][]" required><br>
                <input type="text" name="reponses[${compteurQuestions}][]" required><br>
                <input type="text" name="reponses[${compteurQuestions}][]" required><br>

                <label>Indice de la bonne réponse (0-3) :</label><br>
                <input type="number" name="bonnes_reponses[]" min="0" max="3" required><br><br>
            `;

            container.appendChild(bloc);
            compteurQuestions++;
        }
    </script>
<style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f9;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
    background-color: #2c3e50;
    color: white;
    padding: 20px 0;
    margin-bottom: 30px;
}

form {
    max-width: 700px;
    margin: 0 auto;
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
    color: #2c3e50;
}

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.question-block {
    margin-bottom: 30px;
    border-top: 2px solid #ecf0f1;
    padding-top: 20px;
}

button[type="button"],
button[type="submit"] {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 10px 5px 0 0;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #2980b9;
}

a {
    display: block;
    margin-top: 20px;
    text-align: center;
    color: #3498db;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

p {
    text-align: center;
    font-weight: bold;
}

</style>
</body>
</html>
<div class="calss">hello world</div>