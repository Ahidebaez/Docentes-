<?php
// Mostrar errores
error_reporting(E_ALL); 
ini_set('display_errors', 1);

// CONEXIÓN A LA BASE DE DATOS
$servername = "localhost";
$username = "root";
$password = "";
$database = "mi_base_de_datos";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables para los mensajes
$updateMessage = "";
$errorMessage = "";

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido_paterno = $conn->real_escape_string($_POST['apellido_paterno']);
    $apellido_materno = $conn->real_escape_string($_POST['apellido_materno']);
    $numero = $conn->real_escape_string($_POST['numero']);
    $curp = $conn->real_escape_string($_POST['curp']);
    $email = $conn->real_escape_string($_POST['email']);
    $edad = $conn->real_escape_string($_POST['edad']);

    $sql = "UPDATE docente SET nombre='$nombre', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno', numero='$numero', curp='$curp', email='$email', edad='$edad' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        // Redirigir a la misma página con el parámetro id para evitar el mensaje de error
        header("Location: editar.php?id=$id&updated=true");
        exit();
    } else {
        $errorMessage = "Error actualizando el usuario: " . $conn->error;
    }
}

// Obtener datos del usuario a editar
if (isset($_GET["id"])) {
    $id = $conn->real_escape_string($_GET["id"]);
    $sql = "SELECT nombre, apellido_paterno, apellido_materno, numero, curp, email, edad FROM docente WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row["nombre"];
        $apellido_paterno = $row["apellido_paterno"];
        $apellido_materno = $row["apellido_materno"];
        $numero = $row["numero"];
        $curp = $row["curp"];
        $email = $row["email"];
        $edad = $row["edad"];
    } else {
        $errorMessage = "Usuario no encontrado";
    }
} else {
    $errorMessage = "ID de usuario no especificado";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Docente</title>
    <style>
        body {
            background-color: #E6E6FA; /* Color morado pastel */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #4B0082; /* Color de título */
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            background-color: #4B0082;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #9370DB;
        }
        .message {
            text-align: center;
            font-weight: bold;
        }
        .success-message {
            color: green;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
<h2>Editar Docente</h2>
<div class="form-container">
<?php
if (isset($_GET['updated']) && $_GET['updated'] == 'true') {
    echo "<p class='message success-message'>Usuario modificado</p>";
}
if (!empty($errorMessage)) {
    echo "<p class='message error-message'>$errorMessage</p>";
}
?>
<form action="editar.php" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" maxlength="20" required><br>
    Apellido Paterno: <input type="text" name="apellido_paterno" value="<?php echo htmlspecialchars($apellido_paterno); ?>" maxlength="10" required><br>
    Apellido Materno: <input type="text" name="apellido_materno" value="<?php echo htmlspecialchars($apellido_materno); ?>" maxlength="15" required><br>
    Número de Trabajador: <input type="text" name="numero" value="<?php echo htmlspecialchars($numero); ?>" maxlength="3" required><br>
    CURP: <input type="text" name="curp" value="<?php echo htmlspecialchars($curp); ?>" maxlength="18" required><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" maxlength="40" required><br>
    Edad: <input type="number" name="edad" value="<?php echo htmlspecialchars($edad); ?>" max="99" required><br>
    <input type="submit" name="editar" value="Actualizar Usuario">
</form>
</div>
<a class="btn" href="index.php">Volver a la lista</a>
</body>
</html>