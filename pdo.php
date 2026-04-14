<?php
try {
    $pdo = new PDO("mysql:host=ip_db;dbname=nome_db", "username_db", "password_db");
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
}
?>