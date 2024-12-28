<?php
// Mostrar todos los errores y advertencias


// Configuración de la base de datos
$servername = "127.0.0.1"; // Dirección del servidor
$username = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$dbname = "contact_form"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Verificar si los campos no están vacíos
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Por favor, completa todos los campos.";
    } else {
        // Preparar la consulta SQL con parámetros
        $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        // Ejecutar la consulta
     if ($stmt->execute()) {
            echo "¡Mensaje enviado con éxito!";
            
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    }
}

// Cerrar la conexión
$conn->close();
?>