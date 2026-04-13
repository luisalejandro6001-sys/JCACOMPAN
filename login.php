<?php
session_start();

// Si el usuario ya está logueado, mándalo directo a la cartelera
if (isset($_SESSION['rol'])) {
    header("Location: cartelera.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - JCA Informativo</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .login-box { max-width: 400px; margin: 100px auto; background: white; padding: 30px; border-radius: 15px; shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .btn-login { width: 100%; background: #1a73e8; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-size: 16px; }
    </style>
</head>
<body style="background: #e9ecef;">

<div class="login-box">
    <h2 style="text-align:center;">Acceso JCA</h2>
    <form action="validar.php" method="POST">
        <div class="form-group">
            <label>Usuario:</label>
            <input type="text" name="usuario" required placeholder="Tu usuario admin">
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required placeholder="********">
        </div>
        <button type="submit" class="btn-login">Ingresar al Sistema</button>
        <center><br><br><a href="index.php" class="btn-login">volver</a></center>
        
    </form>
</div>

</body>
</html>