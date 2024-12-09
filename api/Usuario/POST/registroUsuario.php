<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

include "../../connection.php";
include "../Usuario-class.php";

$response = array(
    'success' => false,
    'message' => 'No se pudo registrar el usuario.'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['name']) && isset($data['password'])) {
        $usuario = new Usuario($connection);
        $usuario->setName($data['name']); 
        $usuario->setPassword( $data['password']);
        if ($usuario->register()) {
            $response = [
                'success' => true,
                'message' => 'Usuario registrado exitosamente.'
            ];
        } else {
            $response['message'] = 'Error al registrar el usuario.';
        }
    } else {
        $response['message'] = 'Faltan campos obligatorios (nombre, password).';
    }
} else {
    $response['message'] = 'Método no permitido. Solo se permite POST.';
}

// Enviar respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
