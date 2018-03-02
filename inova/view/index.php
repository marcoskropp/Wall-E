<?php
require_once '../classes/Conexao.class.php';
require_once '../classes/DAO/CoordenadasDAO.class.php';

$coordenadasDAO = new CoordenadasDAO;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link href="../css/materialize.css" rel="stylesheet" type="text/css"/>
  <title>Drone for industry 4.0</title>
  <style>
  #map {
    height: 550px;
    width: 100%;
  }
  #img{
    height: 250px;
    width: 250px;
    margin-top: 5%;
  }
  </style>
</head>
<body class="background blue lighten-4">
  <div class="row">
    <div class="col l4 center s12">
      <h1>Welcome</h1>
      <h4>Drone for industry 4.0</h4>
      <br>
      <a class="btn-large" href="destino.php">Definir destino</a>
      <a class="btn-large" href="geolocation.php">Localização atual</a>
      <div  id="geo"></div>
      <br>
      <br>
      <br>
      <?php foreach ($coordenadasDAO->buscarCoordenadaAtual() as $row) { ?>
        <input id="latitudeCentro" type="hidden" value="<?= $row['latitude'] ?>">
        <input id="longitudeCentro" type="hidden" value="<?= $row['longitude'] ?>">
        <?php } ?>
      </div>
      <div class="col l8 s12" id="mapa">
        <div id="map"></div>
        <script>
        function initMap() {
          var latitude = document.getElementById('latitudeCentro').value;
          var longitude = document.getElementById('longitudeCentro').value;
          var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: 20
          });
          downloadUrl('posicoes.php', function (data) {
            var xml = data.responseXML;

            var markers = xml.documentElement.getElementsByTagName('marker');

            Array.prototype.forEach.call(markers, function (markerElem) {
              var idAtual = markerElem.getAttribute('idAtual');
              var currentPoint = new google.maps.LatLng(
                parseFloat(markerElem.getAttribute('latAtual')),
                parseFloat(markerElem.getAttribute('lngAtual')));

                var markerAtual = new google.maps.Marker({
                  map: map,
                  position: currentPoint,
                  icon: 'http://maps.google.com/mapfiles/kml/pal3/icon32.png'
                });

                var idDestino = markerElem.getAttribute('idDestino');
                var targetPoint = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('latDestino')),
                  parseFloat(markerElem.getAttribute('lngDestino')));
                  var markerDestino = new google.maps.Marker({
                    map: map,
                    position: targetPoint,
                    icon: 'http://maps.google.com/mapfiles/kml/pal5/icon13.png'
                  });

                  var latitudeI = markerElem.getAttribute('latAtual');
                  var longitudeI = markerElem.getAttribute('lngAtual');
                  var latitudeF = markerElem.getAttribute('latDestino');
                  var longitudeF = markerElem.getAttribute('lngDestino');

                  calcular(latitudeI, longitudeI, latitudeF, longitudeF);

                });
              });
            }
            function downloadUrl(url, callback) {
              var request = window.ActiveXObject ?
              new ActiveXObject('Microsoft.XMLHTTP') :
              new XMLHttpRequest;
              request.onreadystatechange = function () {
                if (request.readyState == 4) {
                  request.onreadystatechange = doNothing;
                  callback(request, request.status);
                }
              };
              request.open('GET', url, true);
              request.send(null);
            }
            function doNothing() {}
            </script>
            <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAW4qh9fNU5pMJQrF5qoIDGASGQEYWWnSQ&callback=initMap">
            </script>
          </div>
        </div>
        <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
        <script src="../js/materialize.js" type="text/javascript"></script>
        <script>
        function calcular(latI, lngI, latF, lngF) {
          var latitudeI = parseFloat(latI);
          var longitudeI = parseFloat(lngI);
          var latitudeF = parseFloat(latF);
          var longitudeF = parseFloat(lngF);
          latitudeI = latitudeI.toFixed(6);
          longitudeI = longitudeI.toFixed(6);
          var grauLatitudeI = parseInt(latitudeI);
          var decimalLatitudeI = (Math.abs(latitudeI % 1)) * 60;
          var minutoLatitudeI = parseInt(decimalLatitudeI);
          var segundoLatitudeI = (Math.abs((decimalLatitudeI % 1) * 60)).toFixed(3);
          if (latitudeI > 0)
          var cardealLatitudeI = "N";
          else
          var cardealLatitudeI = "S"
          var grauLongitudeI = parseInt(longitudeI);
          var decimalLongitudeI = (Math.abs(longitudeI % 1)) * 60;
          var minutoLongitudeI = parseInt(decimalLongitudeI);
          var segundoLongitudeI = (Math.abs((decimalLongitudeI % 1) * 60)).toFixed(3);
          if (latitudeI > 0)
          var cardealLongitudeI = "L";
          else
          var cardealLongitudeI = "O"

          latitudeF = latitudeF.toFixed(6);
          longitudeF = longitudeF.toFixed(6);
          var grauLatitudeF = parseInt(latitudeF);
          var decimalLatitudeF = (Math.abs(latitudeF % 1)) * 60;
          var minutoLatitudeF = parseInt(decimalLatitudeF);
          var segundoLatitudeF = (Math.abs((decimalLatitudeF % 1) * 60)).toFixed(3);
          if (latitudeF > 0)
          var cardealLatitudeF = "N";
          else
          var cardealLatitudeF = "S"
          var grauLongitudeF = parseInt(longitudeF);
          var decimalLongitudeF = (Math.abs(longitudeF % 1)) * 60;
          var minutoLongitudeF = parseInt(decimalLongitudeF);
          var segundoLongitudeF = (Math.abs((decimalLongitudeF % 1) * 60)).toFixed(3);
          if (latitudeF > 0)
          var cardealLongitudeF = "L";
          else
          var cardealLongitudeF = "O"

          console.log("Latitude Inicial: " + grauLatitudeI + "º " + minutoLatitudeI + "' " + segundoLatitudeI + "\" " + cardealLatitudeI);
          console.log("Latitude Final: " + grauLatitudeF + "º " + minutoLatitudeF + "' " + segundoLatitudeF + "\" " + cardealLatitudeF);
          console.log("Longitude Inicial: " + grauLongitudeI + "º " + minutoLongitudeI + "' " + segundoLongitudeI + "\" " + cardealLongitudeI);
          console.log("Longitude Final: " + grauLongitudeF + "º " + minutoLongitudeF + "' " + segundoLongitudeF + "\" " + cardealLongitudeF);

          var dlaG = ((-grauLatitudeF) - (-grauLatitudeI)) * 60;
          var dlaM = ((-minutoLatitudeF) - (-minutoLatitudeI)) * 1;
          var dlaS = ((-segundoLatitudeF) - (-segundoLatitudeI)) / 60;
          var dla = ((dlaG + dlaM + dlaS) * 1852);

          var dloG = ((-grauLongitudeF) - (-grauLongitudeI)) * 60;
          var dloM = ((-minutoLongitudeF) - (-minutoLongitudeI)) * 1;
          var dloS = ((-segundoLongitudeF) - (-segundoLongitudeI)) / 60;
          var dlo = ((dloG + dloM + dloS) * 1852);
          var dt = parseInt(Math.sqrt(Math.pow(dla, 2) + Math.pow(dlo, 2)));




          console.log(dt + " Metros");
          var dtM = parseInt(dt / 1000);
          var dtMA = dt - (dtM * 1000);
          //console.log(dtM + " - 1000");

          var dtC = parseInt(dtMA / 100);
          var dtCA = dtMA - (dtC * 100);
          //console.log(dtC + " - 100");

          var dtD = parseInt(dtCA / 10);
          var dtDA = dtCA - (dtD * 10);
          //console.log(dtD + " - 10");

          var dtU = parseInt(dtDA);
          //console.log(dtU + " - 1");

          $('#geo').append('<h1 class="black-text">' + dt + 'm</h1>');


          var array = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
          for (var i = 0; i < array.length; i++) {
            if (dtM == i) {
              var distanciaM = "Milhar" + array[i];
            }
            if (dtC == i) {
              var distanciaC = "Centena" + array[i];
            }
            if (dtD == i) {
              var distanciaD = "Dezena" + array[i];
            }
            if (dtU == i) {
              var distanciaU = "Unidade" + array[i];
            }
          }
          console.log(distanciaM + distanciaC + distanciaD + distanciaU);
          $.ajax({
            url: 'http://10.3.118.201/?function=' + distanciaM + distanciaC + distanciaD + distanciaU,
            dataType: 'html',
            type: 'get',
            beforeSend: function () {

            },
            success: function () {
              alert('asdasd');
            }
          });
        }
        </script>
      </body>
      </html>
