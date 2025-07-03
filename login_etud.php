<?php
session_start();
require_once('../config/config.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $motdepasse = $_POST['motdepasse'];

    $connexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($connexion->connect_error) {
        die("Erreur connexion : " . $connexion->connect_error);
    }

    $requete = $connexion->prepare("SELECT * FROM Etudiant WHERE Login_Etud = ? AND MP_Etud = ?");
    $requete->bind_param("ss", $login, $motdepasse);
    $requete->execute();
    $resultat = $requete->get_result();

    if ($resultat->num_rows === 1) {
        $etudiant = $resultat->fetch_assoc();
        $_SESSION['etudiant_id'] = $etudiant['ID_Etud'];
        $_SESSION['etudiant_nom'] = $etudiant['Nom_Etud'];
        header('Location: dashboard_etud.php');
        exit;
    } else {
        $message = "Login ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Étudiant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Connexion Étudiant</h1>

    <?php if ($message): ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Login:</label><br>
        <input type="text" name="login" required><br><br>

        <label>Mot de passe:</label><br>
        <input type="password" name="motdepasse" required><br><br>

        <button type="submit">Se connecter</button>
    </form>

    <a href="index.php">Retour à l'accueil</a>
    <style>
        /* style.css */

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #ecf0f1;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

h1 {
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    width: 100%;
    text-align: center;
    margin-bottom: 30px;
}

form {
    background-color: white;
    border: 1px solid #bdc3c7;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: left;
}

label {
    font-weight: bold;
    color: #2c3e50;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #bdc3c7;
    border-radius: 5px;
}

button {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100%;
}

button:hover {
    background-color: #2980b9;
}

a {
    margin-top: 20px;
    display: inline-block;
    color: #3498db;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

p {
    margin-bottom: 20px;
}

    </style>
</body>
</html>
