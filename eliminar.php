<?php
require_once 'config/conexion.php';
session_start();

// 1. SEGURIDAD: Solo el admin entra aquí
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado.");
}

// 2. Verificar que recibimos un ID válido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // 3. Primero buscamos si hay un archivo (foto/video) asociado para borrarlo
        $stmt = $pdo->prepare("SELECT archivo FROM publicaciones WHERE id = ?");
        $stmt->execute([$id]);
        $publicacion = $stmt->fetch();

        if ($publicacion) {
            // Borrar el archivo de la carpeta uploads si existe
            if (!empty($publicacion['archivo'])) {
                $ruta_archivo = "uploads/" . $publicacion['archivo'];
                if (file_exists($ruta_archivo)) {
                    unlink($ruta_archivo);
                }
            }

            // 4. Ahora eliminamos el registro de la base de datos JCA
            // Nota: Si usas comentarios, asegúrate de que la tabla comentarios 
            // tenga ON DELETE CASCADE o borra los comentarios primero aquí.
            $delete = $pdo->prepare("DELETE FROM publicaciones WHERE id = ?");
            $delete->execute([$id]);
        }

        header("Location: index.php?msg=eliminado");
        exit();

    } catch (PDOException $e) {
        die("Error al eliminar: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
}