<?php
session_start(); // Démarre la session

include "../../RESSOURCES/general/BDD.php";

// Gestion de l'ajout d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST["role"];

    
    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO role (Role) VALUES (:role)");
    $stmt->execute([
        'role' => $role
    ]);

    // Redirection ou message de succès
    header("Location: index.php"); // Redirige vers la liste des utilisateurs après l'ajout
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Role</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<header>
<?php 
    include "../../RESSOURCES/general/NavBar.php";
    ?>
</header>
<body>
    <h1>Créer un Role</h1>
    <form method="post" action="">
        <input type="text" name="role" placeholder="role" required>
        <button type="submit">Créer Role</button>
    </form>
    <a href="./">Retour à la liste des roles</a>
</body>
</html>
