<?php
session_start();
include 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
    $publicacion_id = $_POST['publicacion_id'];
    $contenido = $_POST['contenido'];
    $usuario_id = $_SESSION['id'];

    $sql = "INSERT INTO comentarios (publicacion_id, usuario_id, contenido) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$publicacion_id, $usuario_id, $contenido]);

    header("Location: cartelera.php");
    exit();
}