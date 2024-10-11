<?php
// Démarre la session
session_start();

include "../../RESSOURCES/general/BDD.php";

// Vérification de l'ID de l'utilisateur à mettre à jour
$idRole = $_GET['id'] ?? null;

if (!$idRole) {
    die("ID d'utilisateur manquant.");
}

// Récupération de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM role WHERE IdRole = :id");
$stmt->execute(['id' => $idRole]);
$resultRole = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resultRole) {
    die("Utilisateur non trouvé.");
}

// Gestion de la mise à jour de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idRole = $_POST['IdRole'] ?? '';
    $role = $_POST["role"];

    // Mise à jour de l'utilisateur dans la base de données
    $stmt = $pdo->prepare("UPDATE role SET Role = :role WHERE IdRole = :idRole");
    $stmt->execute([
        'role' => $role,
        'idRole' => $idRole,
    ]);

    // Redirection ou message de succès
    header("Location: ./"); // Redirige vers la liste des utilisateurs après la mise à jour
    exit;
}

// Récupération des rôles pour le sélecteur
$stmt = $pdo->query("SELECT * FROM Role");
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mettre à jour le role</title>
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
<body>
    <h1>Mettre à jour le role</h1>
    <form method="post" action="">
        <input type="text" name="role" value="<?php echo $resultRole['Role']; ?>" placeholder="role" required>
        <input type="hidden" name="IdRole" value="<?php echo $resultRole["IdRole"]; ?>">
           
        <button type="submit">Mettre à jour le role</button>
    </form>
    <a href="./">Retour à la liste des roles</a>
</body>
</html>
