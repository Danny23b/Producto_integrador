<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Subir imagenes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "C:/xampp/htdocs/Producto integrador/uploads/$user_id";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Valida el tipo de archivo
    if (in_array($file_type, ['jpg', 'png', 'jpeg'])) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $pdo->prepare("INSERT INTO images (user_id, file_path) VALUES (:user_id, :file_path)");
            $stmt->execute(['user_id' => $user_id, 'file_path' => "uploads/$user_id/$file_name"]);
            echo "Imagen subida exitosamente.";
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "Formato de archivo no permitido.";
    }
}

// Obtiene las imágenes del usuario
$stmt = $pdo->prepare("SELECT * FROM images WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de <?php echo htmlspecialchars($username); ?></title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($username); ?> - Tu Galería</h2>
    <form action="gallery.php" method="POST" enctype="multipart/form-data">
        <label for="image">Subir Imagen:</label>
        <input type="file" name="image" required>
        <button type="submit">Subir</button>
    </form>

    <h3>Imágenes</h3>
    <div>
        <?php foreach ($images as $image): ?>
            <div>
                <img src="../<?php echo $image['file_path']; ?>" alt="Imagen" style="max-width: 200px;">
                <form action="delete_image.php" method="POST">
                    <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
