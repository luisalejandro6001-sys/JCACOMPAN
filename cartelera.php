<?php
session_start();
include 'config/conexion.php'; // Asegúrate de que la ruta a tu conexión sea correcta

// 1. Manejo de Sesión y Roles
// Si no hay sesión, asumimos 'invitado'
$rol = $_SESSION['rol'] ?? 'invitado'; 

// 2. Obtener Publicaciones de la DB
$publicaciones = [];
try {
    $query = $pdo->query("SELECT * FROM publicaciones ORDER BY fecha_creacion DESC");
    $publicaciones = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al consultar publicaciones: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartelera Informativa JCA</title>
    <link rel="stylesheet" href="css/cartelera.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
<a href="index.php" class="btn-login-nav">volver</a>
    <div class="logo"><h3>JCA <span>Informativo</span></h3></div>
    <div class="user-info">
    <div class="logo">    <?php if (isset($_SESSION['rol'])): ?>
            <span>Sesión: <strong><?php echo ucfirst($_SESSION['rol']); ?></strong></span>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.php" class="btn-login-nav">Ingresar</a>
        <?php endif; ?>

    </div>
</nav>

<div class="container">

    <?php if ($rol === 'admin'): ?>
        <section class="admin-panel">
            <h2>Crear Nueva Publicación</h2>
            <form action="postear.php" method="POST" enctype="multipart/form-data" class="post-form">
                <input type="text" name="titulo" placeholder="Título de la noticia..." required>
                <textarea name="descripcion" rows="3" placeholder="¿Qué está pasando?" required></textarea>
                
                <div class="file-upload">
                    <label for="archivo">Adjuntar Imagen o Video:</label>
                    <input type="file" name="archivo" id="archivo" accept="image/*,video/*">
                </div>
                
                <button type="submit" class="btn-submit">Publicar Ahora</button>
            </form>
        </section>
    <?php else: ?>
        <div class="alert-info">
            <p>ℹ️ Estás viendo la cartelera como <strong>Invitado</strong>. Solo el administrador puede crear publicaciones.</p>
        </div>
    <?php endif; ?>

    <main class="feed">
        <?php if (empty($publicaciones)): ?>
            <div class="no-posts">Aún no hay publicaciones en la cartelera.</div>
        <?php else: ?>
            
            <?php foreach ($publicaciones as $post): ?> <article class="card">
                    
                    <?php if (!empty($post['imagen_url'])): ?>
                        <div class="card-media">
                            <?php if (strpos($post['tipo_archivo'], 'video') !== false): ?>
                                <video src="<?= $post['imagen_url'] ?>" controls></video>
                            <?php else: ?>
                                <img src="<?= $post['imagen_url'] ?>" alt="Imagen de la noticia">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <h3 class="card-title"><?= htmlspecialchars($post['titulo']) ?></h3>
                        <p class="card-desc"><?= nl2br(htmlspecialchars($post['descripcion'])) ?></p>
                    </div>

                    <section class="comments-section" style="padding: 15px; background: #f9f9f9; border-top: 1px solid #eee;">
                        <h4>Comentarios</h4>
                        <div class="comments-list">
                            
                            // Consultamos los comentarios de este post específico
                            <section class="comments-section" style="padding: 15px; background: #f4f4f4; border-top: 1px solid #ddd; margin-top: 10px;">
    <h4 style="margin-bottom: 10px;">Comentarios</h4>
    
    <div class="comments-list">
        <?php
        // Ajustado a tus nombres: publicacion_id y usuario_id
        $stmt_com = $pdo->prepare("SELECT c.*, u.username FROM comentarios c 
                                    JOIN usuarios u ON c.usuario_id = u.id 
                                    WHERE c.publicacion_id = ? 
                                    ORDER BY c.fecha_comentario ASC");
        $stmt_com->execute([$post['id']]);
        $comentarios_post = $stmt_com->fetchAll();

        if ($comentarios_post): 
            foreach($comentarios_post as $com): ?>
                <div style="background: white; padding: 8px; border-radius: 5px; margin-bottom: 5px; border: 1px solid #eee;">
                    <strong style="color: #007bff;"><?= htmlspecialchars($com['username']) ?>:</strong> 
                    <span><?= htmlspecialchars($com['contenido']) ?></span>
                </div>
            <?php endforeach; 
        else: ?>
            <p style="color: #888; font-size: 0.9em;">No hay comentarios todavía.</p>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['rol'])): ?>
        <form action="comentar.php" method="POST" style="display: flex; gap: 5px; margin-top: 10px;">
            <input type="hidden" name="publicacion_id" value="<?= $post['id'] ?>">
            <input type="text" name="contenido" placeholder="Escribe un comentario..." required 
                   style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit" style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">
                Enviar
            </button>
        </form>
    <?php endif; ?>
</section>

                </article>
            <?php endforeach; ?> <?php endif; ?>
    </main>
</div>

</body>
</html>