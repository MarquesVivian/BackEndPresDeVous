<?php
// Démarre la session
session_start();

include "../../RESSOURCES/general/BDD.php";

// Vérification de l'ID de l'utilisateur à mettre à jour
$idUtilisateur = $_GET['id'] ?? null;

if (!$idUtilisateur) {
    die("ID d'utilisateur manquant.");
}

// Récupération de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE IdUtilisateur = :id");
$stmt->execute(['id' => $idUtilisateur]);
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$utilisateur) {
    die("Utilisateur non trouvé.");
}

// Gestion de la mise à jour de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $numeroTel = $_POST['numeroTel'] ?? '';
    $handic = isset($_POST['handic']) ? 1 : 0; // 1 si checkbox cochée, 0 sinon
    $role = $_POST["role"];

    // Mise à jour de l'utilisateur dans la base de données
    $stmt = $pdo->prepare("UPDATE Utilisateur SET Email = :email, Nom = :nom, Prenom = :prenom, Adresse = :adresse, NumeroTel = :numeroTel, Handic = :handic, IdRole = :idRole WHERE IdUtilisateur = :id");
    $stmt->execute([
        'email' => $email,
        'nom' => $nom,
        'prenom' => $prenom,
        'adresse' => $adresse,
        'numeroTel' => $numeroTel,
        'handic' => $handic,
        'idRole' => $role,
        'id' => $idUtilisateur
    ]);

    // Redirection ou message de succès
    header("Location: utilisateurs.php"); // Redirige vers la liste des utilisateurs après la mise à jour
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
    <title>Mettre à jour l'Utilisateur</title>
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
    <h1>Mettre à jour l'Utilisateur</h1>
    <form method="post" action="">
        <input type="email" name="email" value="<?php echo htmlspecialchars($utilisateur['Email']); ?>" placeholder="Email" required>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($utilisateur['Nom']); ?>" placeholder="Nom" required>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($utilisateur['Prenom']); ?>" placeholder="Prénom" required>
        <input type="text" name="adresse" value="<?php echo htmlspecialchars($utilisateur['Adresse']); ?>" placeholder="Adresse">
        <input type="text" name="numeroTel" value="<?php echo htmlspecialchars($utilisateur['NumeroTel']); ?>" placeholder="Numéro de Téléphone" maxlength="10" required>
        
        Role : 
        <select name="role" id="role">
            <?php 
            foreach ($roles as $role) {
                // Pré-sélectionner le rôle de l'utilisateur actuel
                $selected = ($role['IdRole'] == $utilisateur['IdRole']) ? 'selected' : '';
                echo "<option value='".$role["IdRole"]."' $selected>".$role["Role"]."</option>";
            }
            ?>
        </select>
        
        <div>
            <label for="handic">Handicape :</label>
            <input type="checkbox" name="handic" style="width: 20px;" <?php echo $utilisateur['Handic'] ? 'checked' : ''; ?>>
        </div>
        
        <button type="submit">Mettre à jour l'Utilisateur</button>
    </form>
    <a href="./">Retour à la liste des utilisateurs</a>
</body>
</html>
