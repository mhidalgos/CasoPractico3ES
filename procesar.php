<?php
$serv = "localhost";
$user = "root";
$passw = "jcalleca22.";
$bd = "casoUD3ES";
$conn = new mysqli($serv, $user, $passw, $bd);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $categoria = $_POST['categoria'] ?? '';
    $palabra_clave = $_POST['palabra_clave'] ?? '';
    $fecha = $_POST['fecha'] ?? '';

    $query = "SELECT * FROM articulos WHERE 1=1";

    if (!empty($categoria)) {
        $query .= " AND categoria = '" . $conn->real_escape_string($categoria) . "'";
    }
    if (!empty($palabra_clave)) {
        $query .= " AND titulo LIKE '%" . $conn->real_escape_string($palabra_clave) . "%'";
    }
    if (!empty($fecha)) {
        $query .= " AND fecha = '" . $conn->real_escape_string($fecha) . "'";
    }

    $result = $conn->query($query);

    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Resultados de Búsqueda</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <div class='container'>
            <h2>Resultados de la búsqueda</h2>";
    
    if ($result && $result->num_rows > 0) {
        echo "<table>
                <tr><th>Título</th><th>Categoría</th><th>Fecha</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['titulo']}</td>
                    <td>{$row['categoria']}</td>
                    <td>{$row['fecha']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron resultados.</p>";
    }

    echo "</div>
    </body>
    </html>";
}
$conn->close();
?>
