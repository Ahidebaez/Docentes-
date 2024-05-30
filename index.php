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

// Procesar formulario de nuevo docente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {
    $nombre = $conn->real_escape_string($_POST["nombre"]);
    $apellido_paterno = $conn->real_escape_string($_POST["apellido_paterno"]);
    $apellido_materno = $conn->real_escape_string($_POST["apellido_materno"]);
    $numero = $conn->real_escape_string($_POST["numero"]);
    $curp = $conn->real_escape_string($_POST["curp"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $edad = $conn->real_escape_string($_POST["edad"]);

    $stmt = $conn->prepare("INSERT INTO docente (nombre, apellido_paterno, apellido_materno, numero, curp, email, edad) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $nombre, $apellido_paterno, $apellido_materno, $numero, $curp, $email, $edad);
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Docente agregado correctamente</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Obtener todos los registros de la tabla docente
$sql = "SELECT * FROM docente";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Docentes</title>
    <style>
        body {
            background-color: #E6E6FA; /* Color morado pastel */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h2 {
            color: #4B0082; /* Color de título */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4B0082; /* Color de encabezado de tabla */
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            color: white;
            background-color: #4B0082; /* Color de fondo del botón */
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .btn:hover {
            background-color: #9370DB; /* Color de fondo del botón al pasar el mouse */
        }
        form {
            background-color: #E6E6FA; /* Color morado claro */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            width: 300px;
        }
        input[type="text"], input[type="email"], input[type="number"] {
            padding: 10px;
            margin: 10px 0;
            width: calc(100% - 22px);
            box-sizing: border-box;
            background-color: #F0E6FF; /* Fondo de los campos de texto */
            border: 1px solid #D8BFD8;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #DDA0DD; /* Fondo de los botones */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #BA55D3; /* Fondo más oscuro al pasar el cursor */
        }
    </style>
    <script>
        function validarEdad() {
            var edadInput = document.querySelector('input[name="edad"]');
            if (parseInt(edadInput.value) > 99) {
                edadInput.value = 99;
            }
        }
    </script>
</head>
<body>
<h2>Lista de Docentes</h2>

<!-- Formulario para agregar un nuevo docente -->
<h3>Agregar Nuevo Docente</h3>
<form action="index.php" method="post">
    Nombre: <input type="text" name="nombre" maxlength="15" required><br>
    Apellido Paterno: <input type="text" name="apellido_paterno" maxlength="10" required><br>
    Apellido Materno: <input type="text" name="apellido_materno" maxlength="15" required><br>
    Número de Trabajador: <input type="text" name="numero" maxlength="3" required><br>
    CURP: <input type="text" name="curp" maxlength="18" required><br>
    Email: <input type="email" name="email" maxlength="40" required><br>
    Edad: <input type="number" name="edad" max="99" required oninput="validarEdad()"><br>
    <input type="submit" name="agregar" value="Agregar Docente">
</form>

<!-- Lista de docentes existentes -->
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
        <th>Número de Trabajador</th>
        <th>CURP</th>
        <th>Email</th>
        <th>Edad</th>
        <th>Acciones</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["apellido_paterno"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["apellido_materno"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["numero"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["curp"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["edad"]) . "</td>";
            echo "<td><a class='btn' href='editar.php?id=" . htmlspecialchars($row["id"]) . "'>Editar</a> <a class='btn' href='eliminar.php?id=" . htmlspecialchars($row["id"]) . "'>Eliminar</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No se encontraron registros</td></tr>";
    }
    $conn->close();
    ?>
</table>
</body>
</html>