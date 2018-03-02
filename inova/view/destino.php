<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="../css/materialize.css" rel="stylesheet" type="text/css"/>
        <title>Drone for industry 4.0</title>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAW4qh9fNU5pMJQrF5qoIDGASGQEYWWnSQ&callback=initMap"></script>
        <style>
            html {
                height: 100%;
            }
            body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            #map-canvas {
                margin-top: 1%;
                height: 80%;
                width: 100%;
            }
        </style>
    </head>
    <body class="background blue lighten-4">
        <div class="row" style="height: 100%;">
            <div class="col l3 s12 m12 center">
                <h5 class="center">Escolha um destino</h5>
                <form class="col l12 s12 center" method="POST" id="formulario" action="javascript:;">
                    <input readonly type="text" name="lat" id="lat">
                    <input readonly type="text" name="lng" id="lng">
                    <button type="submit" id="enviar" class="btn">Enviar</button>
                    <a href="index.php" class="btn">Voltar</a>
                    <p id="resposta" style="display: none"></p>
                    <br>
                    <br>
                    <br>
                </form>
                <img src="../img.png" class="responsive-img hide-on-med-and-down">
            </div>
            <div class="col s12 l9 m12" style="height: 100%;">
                <div id="map-canvas"></div>
                <script type="text/javascript" src="../js/map.js"></script>
            </div>

        </div>
        <script src="../js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $('#formulario').submit(function () {
                    var dados = $(this).serialize();
                    $.ajax({
                        url: '../ajax/enviarDestino.php',
                        dataType: 'html',
                        type: 'post',
                        data: dados,
                        beforeSend: function () {
                            $('#enviar').html('...Aguarde');
                            $('#resposta').html('<br><img src="../ajax-loader.gif">').fadeIn(1000);
                        },
                        success: function (retorno) {
                            $('#enviar').html('Enviar');
                            $('#resposta').html(retorno);
                            location.href = 'index.php';
                        }
                    });
                });
            });
        </script>
        <script src="../js/materialize.js" type="text/javascript">

        </script>
    </body>
</html>
