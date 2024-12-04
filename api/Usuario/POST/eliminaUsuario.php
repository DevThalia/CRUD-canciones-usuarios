<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

include "../../connection.php";
include "../Usuario-class.php";

$response = array(
    'success' => false,
    'message' => 'No se pudo eliminar el usuario.'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $usuario = new Usuario($connection, $data['userId']);

    if ($usuario->delete()) {
        $response = [
            'success' => true,
            'message' => 'Usuario eliminado exitosamente.'
        ];
    } else {
        $response['message'] = 'Error al eliminar el usuario.';
    }
}

// Enviar respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

?>