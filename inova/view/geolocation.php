<?php
require_once '../classes/Conexao.class.php';
require_once '../classes/DAO/CoordenadasDAO.class.php';
$coordenadasDAO = new CoordenadasDAO;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Geolocation</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <meta http-equiv="refresh" content="5">
        <link href="../css/materialize.min.css" rel="stylesheet" type="text/css"/>
        <style>
            #map {
                height: 50%;
            }

            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body class="background blue lighten-4">
        <div id="map"></div>
        <br>
        <br>
        <br>
        <div class="container center">
            <a id="resposta" class="btn center-block">..aguarde</a>
            <a id="voltar" class="btn center-block" href="index.php">Voltar</a>
        </div>
        <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
        <script src="../js/materialize.min.js" type="text/javascript"></script>
        <script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: -26.997306, lng: -51.412593},
                    zoom: 5
                });
                var infoWindow = new google.maps.InfoWindow({map: map});
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        var marker = new google.maps.Marker({
                            map: map,
                            position: pos
                        });
                        map.setCenter(pos);
                        enviarDados(pos);
                    }, function () {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                } else {
                    handleLocationError(false, infoWindow, map.getCenter());
                }

            }

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
            }
            function enviarDados(pos) {
                var dados = pos;
                $.ajax({
                    url: '../ajax/enviarLocalizacao.php',
                    dataType: 'html',
                    data: dados,
                    type: 'get',
                    beforeSend: function () {
                        $('#resposta').html("Voltar").fadeIn();
                    },
                    success: function (retorno) {
                        $('#resposta').html(retorno);
                    }
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk-dBp1fYWaa_Yx4sZ6pXlyzOYl6HduFc&callback=initMap"
                async defer>
        </script>
    </body>
</html>
