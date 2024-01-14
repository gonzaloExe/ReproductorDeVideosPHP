<?php
function obtenerNombresVideos($temporada)
{
    $directorio = "./videos/$temporada/";
    $videos = [];

    if (is_dir($directorio)) {
        if ($gestor = opendir($directorio)) {
            while (($archivo = readdir($gestor)) !== false) {
                if ($archivo != "." && $archivo != "..") {
                    $videos[] = $archivo;
                }
            }
            closedir($gestor);
        }
    }

    return $videos;
}

// Obtén el parámetro 'temporada' de la solicitud
$temporada = isset($_GET['temporada']) ? $_GET['temporada'] : '';

// Devuelve los nombres de los videos para la temporada proporcionada
echo json_encode(obtenerNombresVideos($temporada));
?>
