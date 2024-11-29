<?php
session_start();
require_once 'config/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_id'])) {
    $image_id = $_POST['image_id'];
    $user_id = $_SESSION['user_id'];

    // Verifica si la imagen pertenece al usuario
    $stmt = $pdo->prepare("SELECT * FROM images WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $image_id, 'user_id' => $user_id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($image) {
        // Elimina archivo físico
        $file_path = '../' . $image['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Eliminar registro de la base de datos
        $stmt = $pdo->prepare("DELETE FROM images WHERE id = :id");
        $stmt->execute(['id' => $image_id]);
        echo "Imagen eliminada exitosamente.";
    } else {
        echo "No tienes permiso para eliminar esta imagen.";
    }
    header("Location: gallery.php");
}
?>
