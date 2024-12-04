<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include "../../connection.php";
include "../Cancion-class.php";

$response = array(
    'success' => false,
    'message' => 'No se pudo obtener la información de la canción.',
    'data' => array()
);

if (isset($_GET['songId'])) {
    $songId = $_GET['songId'];

    $cancion = new Cancion($connection, $songId);

    $cancion->load($songId);

    if ($cancion->getSongId() !== null) {
        $response['success'] = true;
        $response['message'] = 'Canción obtenida correctamente.';
        $response['data'] = array(
            'title' => $cancion->getTitle(),
            'artist' => $cancion->getArtist(),
            'album' => $cancion->getAlbum(),
            'year' => $cancion->getYear()
        );
    } else {
        $response['message'] = 'No se encontró la canción solicitada.';
    }
} else {
    $response['message'] = 'Falta el parámetro "songId".';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
