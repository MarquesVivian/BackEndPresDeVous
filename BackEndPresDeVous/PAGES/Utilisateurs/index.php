<?php
session_start(); // Démarre la session
include "../../RESSOURCES/general/BDD.php";


// Gérer la suppression d'un utilisateur
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE IdUtilisateur = :id");
    $stmt->execute(['id' => $id]);
    header("Location: ./"); // Redirige après la suppression
    exit;
}

// Récupérer tous les utilisateurs
$stmt = $pdo->query("SELECT * FROM utilisateur INNER JOIN role ON role.IdRole = utilisateur.IdRole");
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<a href="../Login/logout.php">LogOut</a>
</header>
<body>
    <h1>Liste des Utilisateurs</h1>

    <!-- Formulaire pour ajouter un utilisateur -->
    <a href="create.php">
        <h2>Ajouter un Utilisateur</h2>
    </a>

    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Adresse</th>
                <th>NumeroTel</th>
                <th>Handic</th>
                <th>mdp</th>

            </tr>
        </thead>
        <tbody>

        <?php 

        ?>
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                    <td><?= $utilisateur['Email']; ?></td>
                    <td><?= $utilisateur['Role']; ?></td>
                    <td><?= $utilisateur['Nom']; ?></td>
                    <td><?= $utilisateur['Prenom']; ?></td>
                    <td><?= $utilisateur['Adresse']; ?></td>
                    <td><?= $utilisateur['NumeroTel']; ?></td>
                    <td><?= $utilisateur['Handic']; ?></td>
                    <td>***********</td>
                    <td>
                        <a href="update.php?id=<?= $utilisateur['IdUtilisateur']; ?>">Modifier</a>
                        <a href="?delete=<?= $utilisateur['IdUtilisateur']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
