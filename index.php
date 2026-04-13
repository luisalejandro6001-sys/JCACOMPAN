<?php
require_once 'config/conexion.php';
session_start();

// Simulamos los roles para el ejemplo (esto vendría de tu login)
$rolActual = $_SESSION['rol'] ?? 'invitado'; 
$usuarioId = $_SESSION['user_id'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>JCA Company</title>
    <link rel="stylesheet" href="index.css">

</head>
<body>

    <header class="header">
        <div class="menu container">
            <input type="checkbox" id="menu">
            <label for="menu">
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="#">Telegram</a></li>
                    <li><a href="#">Tiktok</a></li>
                    <li><a href="#redes sociales">YouTube</a></li>
                    <li><a href="#footer">Soporte</a></li><br><br>
                    <nav class="navbar">
                    
                   
    
                    
                    <section class="blog container">

</section>
                </ul>
            </nav>
        </div>
        <div class="header-content container">
            <h1>JCA<span>COMPANY</span></h1>
            <p>Una comunidad donde aprenderas todo sobre el trading,<br>
                unete a esta comunidad para que puedas empezar a ganar <br>
                dinero, con cursos y lecciones privadas totalmente gratis. <br>
                Mira el video de abajo, para una Introduccion Rapida<br>
            </p>

            <video controls width="230" height="570" class="video" src="videos/IMG_Introduccion.MP4"></video>

 
        </div>
    </header>
    
    <?php
require_once 'config/conexion.php';
// No es necesario session_start() aquí si ya lo pusiste al inicio del index
?>



<section class="coffee">
    <img class="coffee-img" src="stilos/velas-bajista.pn" alt="">
    <div class="coffee-content container">
        <h2>¡Aprende a predecir las velas!</h2>
        <p class="txt-p">En la comunidad de JCA te enseñaremos a analizar el mercado de forma rápida y sencilla,
            <br> de ese modo aprenderás cuando vender y cuando comprar en el mercado.
            
        </p>
        <div class="coffee-group">
            <div class="coffee-1">
                <img src="stilos/images treding 2.jpg" alt="">
                <h3>Tipos de velas</h3>
                <p>
                     El mercado si lo analizas te puede
                     <br> ayudar a predecir las velas
                </p>
            </div>
            <div class="coffee-1">
                <img src="stilos/images treding.jpg" alt="">
                <h3>Cursos gratis!!</h3>
                <p>
                     <br> adipisicing elit. 
                    <br> El mercado si lo analizas te puede <br> ayudar a predecir las velas
                </p>
            </div>
            <div class="coffee-1">
                <img src="stilos/trading-alcista.jpg" alt="">
                <h3>Aprende del mejor</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur elit. 
                    <br> El mercado si lo analizas te <br> puede ayudar a predecir las velas
                </p>
            </div>
        </div>
        
    </div>
</section>


<main class="services" id="redes sociales">

    <div class="services-content container">
        <h2>Redes sociales</h2>

        <div class="services-group">

            <div class="services-1">
                <a href="https://web.telegram.org/a/#-1002150766046"><img src="logos/icono-telegram.avif" alt=""><h3>Telegram</h3></a>
                
            </div>
            <div class="services-1">
                <a href="https://www.tiktok.com/@jabi_trader?_r=1&_t=ZM-92Dr3KlAi8u"><img src="logos/icono-tiktok.jpg" alt=""><h3>TikTok</h3></a>
                
            </div>
            <div class="services-1">
                <a href="https://www.youtube.com/@ComunidadJCA"><img src="logos/icono-youtube 2.jpg" alt=""><h3>YouTube</h3></a>
                
            </div>

        </div>
        <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
            <br> Eos exercitationem ipsam ut, excepturi eum id doloribus
            <br> repellendus delectus, corrupti eius molestias dolore voluptatibus
            <br> deleniti, quas architecto saepe illum? Ea, nam.
        </p>
        
    </div>
</main>



<section class="news-section">
    <div class="container">
       <center><h2 class="section-title">Actualidad JCA</h2></center> 
            <?php
            // Traemos solo las 3 noticias más recientes
            $stmt = $pdo->query("SELECT * FROM publicaciones ORDER BY fecha_creacion DESC LIMIT 3");
            while ($noticia = $stmt->fetch()):
                // Cortamos el texto para que sea un resumen (150 caracteres)
                $resumen = substr(htmlspecialchars($noticia['descripcion']), 0, 150) . "...";
            ?>
                <div class="news-card">
                    <div class="news-content">
                        <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <p><?php echo $resumen; ?></p>
                        <a href="cartelera.php?id=<?php echo $noticia['id']; ?>" class="btn-ver-mas">
                            Ver más →
                        </a>
                        
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
       
    </div>
</section>

<section class="blog container">
    
    <a href="cartelera.php" class="btn-1">Ver Publicaciones</a>
</section>




<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-section about">
            <h2 class="footer-logo">JCA<span>COMPANY</span></h2>
            <p>Comunidad líder en trading. Aprende estrategias <br> reales y alcanza tu libertad financiera con nosotros.</p>
        </div>

        <div class="footer-section links">
            <h3>Enlaces</h3>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="cartelera.php">Cartelera</a></li>
                <li><a href="soporte.php">Soporte</a></li>
                <li><a href="login.php">Acceso Admin</a></li>
            </ul>
        </div>

        <div class="footer-section social">
            <h3>Síguenos</h3>
            <div class="social-links">
                <a href="#" class="social-icon">Telegram</a>
                <a href="#" class="social-icon">TikTok</a>
                <a href="#" class="social-icon">YouTube</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; 2026 JCA COMPANY | Todos los derechos reservados.
    </div>
</footer>


</body>
</html>