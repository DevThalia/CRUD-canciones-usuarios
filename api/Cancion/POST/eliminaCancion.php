<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

include "../../connection.php";
include "../Cancion-class.php";

$response = array(
    'success' => false,
    'message' => 'No se pudo eliminar la canción.'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $cancion = new Cancion($connection, $data['songId']);

    if ($cancion->delete()) {
        $response = [
            'success' => true,
            'message' => 'Canción eliminada exitosamente.'
        ];
    } else {
        $response['message'] = 'Error al eliminar la canción.';
    }
}

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

?>
