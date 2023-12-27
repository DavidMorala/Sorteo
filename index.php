
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/star.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/star.ico" type="image/x-icon">

    <title>Generador de Equipos y Partidos</title>
</head>
<body>
<div id="cabecera"><p>Sorteo de encuentros</p></div>
<?php
function generarInputs($cantidad) {
    echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'">';
    echo '<input type="hidden" name="equipos" value="'.$cantidad.'">';
    for ($i = 1; $i <= $cantidad; $i++) {
        echo '<label for="equipo'.$i.'">Nombre del Equipo '.$i.': </label>';
        echo '<input type="text" name="equiposArray[]" required><br>';
    }
    echo '<input type="submit" name="generarPartidos" id="gp" value="Generar Partidos">';
    echo '</form>';
}

function generarPartidosAleatorios($equipos) {
    shuffle($equipos);
    $partidos = array_chunk($equipos, 2);
    return $partidos;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crearEquipos'])) {
        $cantidadEquipos = (int)$_POST['crearEquipos'];
        generarInputs($cantidadEquipos);
    }

    if (isset($_POST['generarPartidos'])) {
        $equiposArray = isset($_POST['equiposArray']) ? $_POST['equiposArray'] : [];

        // Mostrar los equipos ingresados
        echo '<h2>Equipos ingresados:</h2>';
        foreach ($equiposArray as $indice => $equipo) {
            echo 'Equipo '.($indice + 1).': '.$equipo.'<br>';
        }

        // Generar y mostrar partidos aleatorios
        $partidos = generarPartidosAleatorios($equiposArray);

        echo '<h2>Emparejamientos Aleatorios:</h2>';
        foreach ($partidos as $indice => $partido) {
            echo '<br> Partido '.($indice + 1).': '.$partido[0].' vs '.$partido[1].'<br>';
            // Agregamos el contenedor para el resultado y el campo de entrada para actualizarlo
            echo '<div id="resultadoPartido'.$indice.'">Resultado: <span>';
            
            // Verificamos si el índice 2 está definido en el array $partido
            if (isset($partido[2])) {
                echo $partido[2];
            }
            
            echo '</span></div>';
            
            echo '<input type="text" id="nuevoResultado'.$indice.'" placeholder="Nuevo Resultado">';
            echo '<button onclick="actualizarResultado('.$indice.')">Actualizar</button>';
        }
    }
}
?>

<!-- Agregamos el script JavaScript -->
<script>
function actualizarResultado(indice) {
    var nuevoResultado = document.getElementById('nuevoResultado' + indice).value;

    // Enviamos el resultado mediante AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Actualizamos el contenido del contenedor del resultado
            document.getElementById('resultadoPartido' + indice).innerHTML = 'Resultado: <span>' + nuevoResultado + '</span>';
        }
    };
    xhttp.open('POST', 'actualizar_resultado.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('indicePartido=' + indice + '&nuevoResultado=' + nuevoResultado);
}
</script>

<h2>Selecciona la cantidad de equipos:</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <button type="submit" name="crearEquipos" value="4">4 Equipos</button>
    <button type="submit" name="crearEquipos" value="6">6 Equipos</button>
    <button type="submit" name="crearEquipos" value="8">8 Equipos</button>
</form>

</body>
</html>