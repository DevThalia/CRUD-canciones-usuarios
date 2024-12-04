<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include "../../connection.php";
include "../Cancion-class.php";

$response = array(
    'success' => false,
    'message' => 'No se pudo editar la canción.'
);

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    if (isset($data['songId'], $data['title'], $data['artist'], $data['album'], $data['year'])) {
        $songId = $data['songId'];
        $title = $data['title'];
        $artist = $data['artist'];
        $album = $data['album'];
        $year = $data['year'];

        $cancion = new Cancion($connection, $songId);

        if ($cancion->update($title, $artist, $album, $year)) {
            $response = [
                'success' => true,
                'message' => 'Canción actualizada exitosamente.'
            ];
        } else {
            $response['message'] = 'Error al actualizar la canción.';
        }
    } else {
        $response['message'] = 'Faltan datos en la solicitud.';
    }
} else {
    $response['message'] = 'Datos inválidos.';
}

// Enviar respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
