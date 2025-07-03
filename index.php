<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion QCM</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Bienvenue sur la plateforme QCM</h1>

    <div class="prof">
        <h2>Espace Professeur</h2>
        <a href="login_prof.php">Se connecter</a>
    </div>

    <div class="etudiant">
        <h2>Espace Étudiant</h2>
        <a href="login_etud.php">Se connecter</a>
    </div>
    <style>
       /* style.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f8;
    margin: 0;
    padding: 0;
    text-align: center;
}

h1 {
    background-color: #2c3e50;
    color: white;
    padding: 20px 0;
    margin-bottom: 40px;
}

div.prof, div.etudiant {
    background-color: white;
    border: 2px solid #3498db;
    border-radius: 12px;
    width: 300px;
    margin: 20px auto;
    padding: 30px 0;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

h2 {
    color: #3498db;
    margin-bottom: 20px;
}

a {
    display: inline-block;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 8px;
    transition: background-color 0.3s;
}

a:hover {
    background-color: #2980b9;
}

    </style>
</body>
</html>
