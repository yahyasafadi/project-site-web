<?php
require_once('../config/config.php');

// Connexion automatique grâce au config.php
$connexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($connexion->connect_error) {
    die('Erreur connexion : ' . $connexion->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom=$_post["nom"];
    $prenom=$_post["prenom"];
    $login_etud=$_post["login"];
    $mp_etud=$_post["mp_etud"];
    // Requête d'insertion
    $requete = $connexion->prepare("INSERT INTO Etudiant (Nom_Etud, Prenom_Etud, Login_Etud, MP_Etud, Email_Etud) VALUES (?, ?, ?, ?, ?)");
    $requete->bind_param("ici",$nom,$prenom,$login_etud,$mp_etud,$email);
    if($requet->execute())
    {
        $message="le login is succeded";
    }
    else{
        $message="le login est failed";
    }
}
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte étudiant</title>
    <style>
   * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #f5f5f5;
    padding: 20px;
}

.title {
    color: #2c3e50;
    text-align: center;
    margin-bottom: 30px;
    font-size: 28px;
    font-weight: 600;
}

.form {
    max-width: 500px;
    margin: 0 auto;
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #34495e;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    transition: border 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
}

button[type="submit"] {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #2980b9;
}

/* Pour les petits écrans */
@media (max-width: 600px) {
    .form {
        padding: 20px;
    }
}
.message-container {
            max-width: 500px;
            margin: 0 auto 20px auto;
        }
</style>
</head>
<body>
    <div class="title">Créer le compte étudiant</div>
    
    <?php if(!empty($message)) echo $message; ?>
    
    <form method="post" class="form">
        <label>Nom :</label>
        <input type="text" name="nom" required>
        
        <label>Prénom :</label>
        <input type="text" name="prenom" required>
        
        <label>Login :</label>
        <input type="text" name="login" required>
        
        <label>Mot de passe :</label>
        <input type="password" name="motdepasse" required>
        
        <label>Email :</label>
        <input type="email" name="email" required>
        
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>





