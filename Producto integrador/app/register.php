<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'user')");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
        echo "Registro exitoso. <a href='login.php'>Iniciar Sesión</a>";
    } catch (PDOException $e) {
        echo "Error al registrar: " . $e->getMessage();
    }
}
?>
