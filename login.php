<?php
// Aquí debes colocar las credenciales de tu base de datos
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "hospital_unicosta";

// Crear una conexión a la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si hay algún error en la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $tipoDocumento = $_POST["tipoDocumento"];
    $numeroDocumento = $_POST["numeroDocumento"];
    $contrasena = $_POST["contrasena"];
    $recordarDatos = isset($_POST["recordarDatos"]) ? true : false;

    // Consulta SQL para verificar los datos en la base de datos
    $sql = "SELECT * FROM usuarios WHERE numerodocumento = '$numeroDocumento'";
    $resultado = $conexion->query($sql);

    // Verificar si se encontró un resultado en la consulta
    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        // Obtener los nombres y apellidos del usuario
        $nombre_usuario = $usuario["nombres"];
        $apellido_usuario = $usuario["apellidos"];

        // Verificar si la contraseña es correcta
        if ($usuario["password"] != $contrasena) {
            echo "<script>alert('Contraseña incorrecta');</script>";
            echo "<script>window.location.href = './afiliados.html';</script>";
            exit();
        } else {
            echo "<script>alert('Bienvenido $nombre_usuario $apellido_usuario');</script>";
            echo "<script>window.location.href = './afiliados/index.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Este documento no se encuentra registrado');</script>";
        echo "<script>window.location.href = './registro.html';</script>";
        exit();
    }
}

$conexion->close();
?>




