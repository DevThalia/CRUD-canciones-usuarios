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
    'message' => 'No se pudo crear la canción.',
    'data' => array()
);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true); 

    if (isset($data['title']) && isset($data['artist']) && isset($data['album']) && isset($data['year'])) {
        $cancion = new Cancion($connection);
        
        $cancion->setTitle($data['title']);
        $cancion->setArtist($data['artist']);
        $cancion->setAlbum($data['album']);
        $cancion->setYear($data['year']);
        
        if ($cancion->create($data['title'], $data['artist'], $data['album'], $data['year'])) {
            $response['success'] = true;
            $response['message'] = 'Canción creada correctamente.';
            $response['data'] = array(
                'title' => $cancion->getTitle(),
                'artist' => $cancion->getArtist(),
                'album' => $cancion->getAlbum(),
                'year' => $cancion->getYear()
            );
        } else {
            $response['message'] = 'Error al crear la canción.';
        }
    } else {
        $response['message'] = 'Faltan datos para crear la canción.';
    }
} else {
    $response['message'] = 'Método de solicitud no permitido. Use POST.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
