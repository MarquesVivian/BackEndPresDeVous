<?php
session_start(); // Démarre la session

include "../../RESSOURCES/general/BDD.php";

// Gestion de l'ajout d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $numeroTel = $_POST['numeroTel'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $handic = isset($_POST['handic']) ? 1 : 0; // 1 si checkbox cochée, 0 sinon
    $dateInscrip = date('Y-m-d H:i:s'); // Date et heure actuelles
    $verifier = 0; // Par défaut, le compte n'est pas vérifié
    $role = $_POST["role"];

    // Hash du mot de passe
    $hashed_password = hash('sha256', $mot_de_passe);
    
    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO Utilisateur (Email, Nom, Prenom, Adresse, NumeroTel, motDePasse, Handic, DateInscrip, Verifier, IdRole) VALUES (:email, :nom, :prenom, :adresse, :numeroTel, :mot_de_passe, :handic, :dateInscrip, :verifier, :idRole)");
    $stmt->execute([
        'email' => $email,
        'nom' => $nom,
        'prenom' => $prenom,
        'adresse' => $adresse,
        'numeroTel' => $numeroTel,
        'mot_de_passe' => $hashed_password,
        'handic' => $handic,
        'dateInscrip' => $dateInscrip,
        'verifier' => $verifier,
        'idRole' => $role
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
    <title>Créer un Utilisateur</title>
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
<a href="../Login/logout.php">LogOut</a>
</header>
<body>
    <h1>Créer un Utilisateur</h1>
    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="text" name="adresse" placeholder="Adresse">
        <input type="text" name="numeroTel" placeholder="Numéro de Téléphone" maxlength="10" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de Passe" required>
        Role : <select name="role" id="role">
            <?php 
            $stmt = $pdo->query("SELECT * FROM role");
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($roles as $role) {
                echo "<option value ='".$role["IdRole"]."'>".$role["Role"]."</option>";
            }
            ?>
        </select>
        <div>
            <label for="handic">Handicape :</label>
            <input type="checkbox" name="handic" style="width: 20px;"> 
        </div>
        <button type="submit">Créer Utilisateur</button>
    </form>
    <a href="utilisateurs.php">Retour à la liste des utilisateurs</a>
</body>
</html>
