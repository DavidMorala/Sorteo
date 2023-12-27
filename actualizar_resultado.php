<?php
// Obtener el índice del partido y el nuevo resultado enviado por AJAX
$indicePartido = isset($_POST['indicePartido']) ? (int)$_POST['indicePartido'] : -1;
$nuevoResultado = isset($_POST['nuevoResultado']) ? $_POST['nuevoResultado'] : '';


$resultadosPartidos = array(
    array('Equipo A', 'Equipo B', '0-0'),
    array('Equipo C', 'Equipo D', '0-0'),
);

// Actualizar el resultado del partido
if ($indicePartido >= 0 && $indicePartido < count($resultadosPartidos)) {
    $resultadosPartidos[$indicePartido][2] = $nuevoResultado;
}

// Respuesta para indicar que la actualización fue exitosa
echo 'Actualización exitosa';
?>
