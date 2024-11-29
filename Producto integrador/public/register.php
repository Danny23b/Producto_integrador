<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form action="register.php" method="POST">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" name="username" required>
        <br>
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
