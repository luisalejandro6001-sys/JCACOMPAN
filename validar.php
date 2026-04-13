<?php
session_start(); // ¡ESTO ES LO PRIMERO!
include 'conexion.php'; // Tu archivo de conexión a la DB

$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Buscamos al usuario en la base de datos
$sql = "SELECT * FROM usuarios WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario]);
$user = $stmt->fetch();

// Verificamos si existe y si la clave coincide
// ... después del $user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) { 
    // password_verify agarra la clave del formulario ($password) 
    // y la compara con la encriptada ($user['password'])
    
    session_start();
    $_SESSION['id'] = $user['id'];
    $_SESSION['rol'] = $user['rol'];
    $_SESSION['nivel'] = $user['rol']; 
    
    header("Location: cartelera.php");
    exit();
} else {
    echo "Usuario o contraseña incorrectos.";
}