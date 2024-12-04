<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include "../../connection.php";
include "../Usuario-class.php";

$response = array(
    'success' => false,
    'message' => 'No se pudo crear el usuario.',
    'data' => array()
);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') { 
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['name']) && isset($data['username']) && isset($data['email']) && isset($data['phone'])) {
        $usuario = new Usuario($connection);

        $usuario->setName($data['name']);
        $usuario->setUsername($data['username']);
        $usuario->setEmail($data['email']);
        $usuario->setPhone($data['phone']);

        if ($usuario->create($data['name'], $data['username'], $data['email'], $data['phone'])) {
            $response['success'] = true;
            $response['message'] = 'Usuario creado correctamente.';
            $response['data'] = array(
                'name' => $usuario->getName(),
                'username' => $usuario->getUsername(),
                'email' => $usuario->getEmail(),
                'phone' => $usuario->getPhone()
            );
        } else {
            $response['message'] = 'Error al crear el usuario.';
        }
    } else {
        $response['message'] = 'Faltan datos para crear el usuario.';
    }
}

echo json_encode($response);

?>
