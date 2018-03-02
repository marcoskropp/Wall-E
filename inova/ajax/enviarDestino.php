<?php

require_once '../classes/Conexao.class.php';
require_once '../classes/entidades/Coordenadas.class.php';
require_once '../classes/DAO/CoordenadasDAO.class.php';

$coordenadas = new Coordenadas;
$coordenadasDAO = new CoordenadasDAO;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$coordenadas->setLatitude(addslashes($dados['lat']));
$coordenadas->setLongitude(addslashes($dados['lng']));

$retorno = $coordenadasDAO->enviarCoordenadaFinal($coordenadas);

if ($retorno) {
    echo 'Localização enviada!';
} else {
    echo 'Falha!';
}
return;

