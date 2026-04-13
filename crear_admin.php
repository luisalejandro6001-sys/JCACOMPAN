<?php
// Incluimos la conexión a la base de datos JCA
require_once 'config/conexion.php';

// --- CONFIGURACIÓN DEL USUARIO ---
$usuarioNombre = 'admin2_jca'; // El nombre que usarás para loguearte
$passwordPlana = 'Admin2024*'; // La contraseña (cámbiala por una segura)
$rolAsignado   = 'admin';      // El nivel de usuario

// 1. Ciframos la contraseña usando el algoritmo estándar de PHP
$passwordCifrada = password_hash($passwordPlana, PASSWORD_DEFAULT);

try {
    // 2. Preparamos la inserción para evitar ataques
    $sql = "INSERT INTO usuarios (username, password, rol) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    // 3. Ejecutamos
    $stmt->execute([$usuarioNombre, $passwordCifrada, $rolAsignado]);

    echo "<h2>✅ Usuario Administrador creado con éxito</h2>";
    echo "<p>Usuario: <strong>$usuarioNombre</strong></p>";
    echo "<p>Rol: <strong>$rolAsignado</strong></p>";
    echo "<p><em>Ya puedes borrar este archivo por seguridad.</em></p>";

} catch (PDOException $e) {
    // Si el usuario ya existe, PDO lanzará un error
    echo "<h2>❌ Error al crear el usuario</h2>";
    echo "Detalle: " . $e->getMessage();
}
?>