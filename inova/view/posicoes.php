<?php

require_once '../classes/Conexao.class.php';
require_once '../classes/DAO/CoordenadasDAO.class.php';

$coordenadasDAO = new CoordenadasDAO;

function parseToXML($htmlStr) {
    $xmlStr = str_replace('<', '&lt;', $htmlStr);
    $xmlStr = str_replace('>', '&gt;', $xmlStr);
    $xmlStr = str_replace('"', '&quot;', $xmlStr);
    $xmlStr = str_replace("'", '&#39;', $xmlStr);
    $xmlStr = str_replace("&", '&amp;', $xmlStr);
    return $xmlStr;
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
foreach ($coordenadasDAO->buscarCoordenadaAtual() as $row_markersAtual) {
    // Add to XML document node
    echo '<marker ';
    echo 'idAtual="' . parseToXML($row_markersAtual['id']) . '" ';
    echo 'latAtual="' . $row_markersAtual['latitude'] . '" ';
    echo 'lngAtual="' . $row_markersAtual['longitude'] . '" ';
}
foreach ($coordenadasDAO->buscarCoordenadaFinal() as $row_markersDestino) {
    echo 'idDestino="' . parseToXML($row_markers['id']) . '" ';
    echo 'latDestino="' . $row_markersDestino['latitude'] . '" ';
    echo 'lngDestino="' . $row_markersDestino['longitude'] . '" ';
    echo '/>';
}
// End XML file
echo '</markers>';
?>