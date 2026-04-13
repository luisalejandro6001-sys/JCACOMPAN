<?php
// 1. Conexión a la base de datos (Ajusta si tienes clave)
$host = 'localhost';
$db   = 'jca'; 
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// 2. Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    
    // Variables para el archivo
    $nombre_archivo = null;
    $tipo_archivo = null;
    $ruta_destino = null;

    // 3. Manejo del archivo subido
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === 0) {
        $directorio_subida = 'uploads/'; // Asegúrate de crear esta carpeta
        
        // Crear la carpeta si no existe
        if (!is_dir($directorio_subida)) {
            mkdir($directorio_subida, 0777, true);
        }

        $nombre_original = $_FILES['archivo']['name'];
        $tipo_archivo = $_FILES['archivo']['type'];
        
        // Evitar nombres duplicados usando el tiempo actual
        $nombre_final = time() . "_" . basename($nombre_original);
        $ruta_destino = $directorio_subida . $nombre_final;

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_destino)) {
            $nombre_archivo = $nombre_final;
        }
    }

    // 4. Insertar en la base de datos según tu imagen
    if ($titulo && $descripcion) {
        try {
            $sql = "INSERT INTO publicaciones (titulo, descripcion, archivo, tipo_archivo, imagen_url) 
                    VALUES (:titulo, :desc, :archivo, :tipo, :url)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo'  => $titulo,
                ':desc'    => $descripcion,
                ':archivo' => $nombre_archivo, // El nombre del archivo guardado
                ':tipo'    => $tipo_archivo,   // image/png, video/mp4, etc.
                ':url'     => $ruta_destino    // La ruta completa para mostrarla luego
            ]);

            echo "Publicación guardada con éxito.";
            header("Location: cartelera.php"); // Redirigir de vuelta a la cartelera
        } catch (Exception $e) {
            echo "Error al insertar: " . $e->getMessage();
        }
    } else {
        echo "El título y la descripción son obligatorios.";
    }
}
?>