<?php
// Connexion à la base de données
$host = 'localhost'; // Adresse du serveur
$dbname = 'presdevous'; // Nom de la base de données
$username = '1_48512'; // Nom d'utilisateur de la base de données
$password = 'Vf8z65vZ/'; // Mot de passe de la base de données

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>