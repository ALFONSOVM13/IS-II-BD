<?php
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "hospital_unicosta";

// Conexión a la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión es exitosa
if ($conexion->connect_error) {
    $error = "Error al conectar a la base de datos: " . $conexion->connect_error;
}

// Obtener los datos enviados desde el formulario
$tipodocumento = $_POST['tipodocumento'];
$numerodocumento = $_POST['numerodocumento'];
$correoElectronico = $_POST['correoElectronico'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];

// Verificar si hay algún error
if (isset($error)) {
    echo '<script>alert("' . $error . '");</script>';
} else {
    // Verificar si el usuario ya está registrado por correo electrónico o número de documento
    $consulta = "SELECT * FROM usuarios WHERE correoElectronico = '$correoElectronico' OR numerodocumento = '$numerodocumento'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {
        // El usuario ya está registrado, mostrar mensaje emergente y redirigir
        if ($resultado->fetch_assoc()['correoElectronico'] === $correoElectronico) {
            echo '<script>alert("Este usuario  con el correo electrónico ' . $correoElectronico . ' ya se encuentra registrado. Serás redirigido a la pagina de inicio de sesión");</script>';
        } else {
            echo '<script>alert("Este usuario con numero de documento  ' . $numerodocumento . ' ya se encuentra registrado.Serás redirigido a la pagina de inicio de sesión");</script>';
        }
        echo '<script>window.location.href = "afiliados.html";</script>';
        exit(); // Asegurarse de detener la ejecución después de la redirección
    } else {
        // Insertar los datos en la tabla de la base de datos
        $sql = "INSERT INTO usuarios (numerodocumento, tipodocumento, correoElectronico, password, nombres, apellidos, fechaNacimiento, direccion, telefono) 
                VALUES ('$numerodocumento', '$tipodocumento', '$correoElectronico', '$password', '$nombres', '$apellidos', '$fechaNacimiento', '$direccion', '$telefono')";

        if ($conexion->query($sql) === TRUE) {
            // Registro exitoso, mostrar mensaje emergente y redirigir
            echo '<script>alert("REGISTRO EXITOSO!");</script>';
            echo '<script>window.location.href = "afiliados.html";</script>';
            exit(); // Asegurarse de detener la ejecución después de la redirección
        } else {
            $error = "Error al registrar el usuario: " . $conexion->error;
            echo '<script>alert("' . $error . '");</script>';
        }
    }
}

$conexion->close();
?>


