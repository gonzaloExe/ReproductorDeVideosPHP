<?php
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

if ($busqueda !== '') {
    $directorio = "./videos/";
    $resultados = [];

    if (is_dir($directorio)) {
        if ($gestor = opendir($directorio)) {
            while (($archivo = readdir($gestor)) !== false) {
                if ($archivo != "." && $archivo != ".." && stripos($archivo, $busqueda) !== false) {
                    $resultados[] = $archivo;
                }
            }
            closedir($gestor);
        }
    }

    echo json_encode($resultados);
} else {
    // Manejar el caso en que no se proporciona una cadena de búsqueda
    echo json_encode([]);
}
?>
