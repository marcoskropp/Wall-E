<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link href="./inova/css/materialize.css" rel="stylesheet" type="text/css"/>
  <title>Drone for industry 4.0</title>
  <style>

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
      <div><h2>1m</h2></div>
      <br>
      <br>
      <br>
      <button type="button" class="btn-large" onclick="ir()"><img src="play.png" class="valign-wrapper"></button>
    </div>
    <div class="col l8 s12">
      <img src="map.png" width="899px">
    </div>
  </div>
  <script type="text/javascript" src="./inova/js/jquery-3.2.1.min.js"></script>
  <script src="./inova/js/materialize.js" type="text/javascript"></script>
  <script>
  var distanciaM = "Milhar0";
  var distanciaC = "Centena0";
  var distanciaD = "Dezena0";
  var distanciaU = "Unidade1";
  console.log(distanciaM + distanciaC + distanciaD + distanciaU);
  $.ajax({
    url: 'http://10.3.118.201/?function=' + distanciaM + distanciaC + distanciaD + distanciaU,
    dataType: 'html',
    type: 'get',
  });
  function ir(){
    $.ajax({
      url: 'http://10.3.118.201/?function=' + distanciaM + distanciaC + distanciaD + distanciaU,
      dataType: 'html',
      type: 'get',
    });
  }
</script>
</body>
</html>
