<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Chavo TV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-3">
        <button class="btn btn-danger me-2" onclick="retrocederVideo()">Retroceder</button>
        <button class="btn btn-danger" onclick="mostrarAlerta()">Inicio</button>
        <button class="btn btn-danger ms-2" onclick="siguienteVideo()">Siguiente</button>
        <a href="index.php" class="btn btn-danger ms-2"><i class="bi bi-house"></i> Hogar</a>
    </div>

    <!-- Contenedor para reproducir videos -->
    <div class="container mt-3">
        <video id="videoPlayer" class="col-12" controls></video>
    </div>

    <!-- Alerta de Bootstrap -->
    <div class="position-fixed top-0 start-50 translate-middle-x mt-5 alert alert-info alert-dismissible fade show" role="alert" id="inicioAlerta">
        Toca "Inicio" para comenzar a ver los videos.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>

    <!-- Scripts de Bootstrap y Popper.js (asegúrate de incluir Popper.js antes de Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- ... (código anterior) ... -->

<!-- ... (código anterior) ... -->

<!-- ... (código anterior) ... -->

<script>
    var videoPlayer = document.getElementById('videoPlayer');
    var temporadas = ['temporada72', 'temporada73', 'temporada74', 'temporada75', 'temporada76'];
    var currentTemporadaIndex = 0;
    var currentVideoIndex = 0;
    var videoList = [];

    function cargarVideoList() {
        temporadas.forEach(function (temporada) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var nombresVideos = JSON.parse(xhr.responseText);
                    videoList.push({ temporada: temporada, videos: nombresVideos });
                }
            };
            xhr.open('GET', 'videos.php?temporada=' + temporada, false);
            xhr.send();
        });
    }

    function iniciarReproduccion() {
        if (currentTemporadaIndex >= videoList.length) {
            currentTemporadaIndex = 0;
        }

        var temporadaActual = videoList[currentTemporadaIndex];
        var videosActuales = temporadaActual.videos;

        if (currentVideoIndex >= videosActuales.length) {
            currentVideoIndex = 0;
            currentTemporadaIndex++; // Avanzar a la siguiente temporada cuando se terminan los videos de la actual
        }

        var nombreVideo = videosActuales[currentVideoIndex];
        videoPlayer.src = './videos/' + temporadaActual.temporada + '/' + nombreVideo;
        videoPlayer.load();
        videoPlayer.play();

        currentVideoIndex++;
    }

    function retrocederVideo() {
        currentVideoIndex -= 1;
        if (currentVideoIndex < 0) {
            if (currentTemporadaIndex > 0) {
                currentTemporadaIndex--; // Retroceder a la temporada anterior si estás al principio de los videos
                var temporadaActual = videoList[currentTemporadaIndex];
                currentVideoIndex = temporadaActual.videos.length - 1; // Último video de la temporada anterior
            } else {
                currentVideoIndex = 0; // Asegurarse de no retroceder más allá del primer video
            }
        }

        iniciarReproduccion();
    }

    function siguienteVideo() {
        iniciarReproduccion();
    }

    // Detectar la interacción del usuario y luego iniciar la reproducción
    document.addEventListener('DOMContentLoaded', function () {
        document.body.addEventListener('click', function () {
            iniciarReproduccion();
        });
    });

    videoPlayer.addEventListener('ended', function () {
        iniciarReproduccion();
    });

    function mostrarAlerta() {
        var inicioAlerta = document.getElementById('inicioAlerta');
        inicioAlerta.style.display = 'block';

        setTimeout(function () {
            inicioAlerta.style.display = 'none';
            iniciarReproduccion(); // Iniciar la reproducción después de ocultar la alerta
        }, 5000);
    }

    cargarVideoList();
</script>

<!-- ... (código posterior) ... -->



<!-- ... (código posterior) ... -->


    <!-- Manejo de errores -->
    <script>
        window.addEventListener('error', function (e) {
            console.error('Error durante la ejecución del script:', e.error);
        });
    </script>

</body>

</html>
