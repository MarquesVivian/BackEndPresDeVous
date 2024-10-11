<?php
session_start(); // Démarre la session
include "../../RESSOURCES/general/BDD.php";


// Gérer la suppression d'un utilisateur
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM role WHERE IdRole = :id");
    $stmt->execute(['id' => $id]);
    header("Location: ./"); // Redirige après la suppression
    exit;
}

// Récupérer tous les utilisateurs
$stmt = $pdo->query("SELECT * FROM role");
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="css.css">

</head>
<header>
    <?php 
    include "../../RESSOURCES/general/NavBar.php";
    ?>
</header>
<body>
    <h1>Liste des Roles</h1>

    <!-- Formulaire pour ajouter un utilisateur -->
    <a href="create.php">
        <h2>Ajouter un Role</h2>
    </a>

    <table>
        <thead>
            <tr>
                <th>libelle</th>


            </tr>
        </thead>
        <tbody>

        <?php 

        ?>
            <?php foreach ($roles as $role): ?>
                <tr>
                    <td><?= $role['Role']; ?></td>
                    <td>
                        <a href="update.php?id=<?= $role['IdRole']; ?>">Modifier</a>
                        <a href="?delete=<?= $role['IdRole']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
