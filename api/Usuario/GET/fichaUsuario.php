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
    'message' => 'No se pudo obtener la información del usuario.',
    'data' => array()
);

if(isset($_GET['userId'])){
    $userId = $_GET['userId'];

    $usuario = new Usuario($connection, $userId);

    $usuario->load($userId);

    if($usuario->getUserId() !== null){
        $response['success'] = true;
        $response['message'] = 'Usuario obtenido correctamente.';
        $response['data'] = array(
            'name' => $usuario->getName(),
            'username' => $usuario->getUsername(),
            'email' => $usuario->getEmail(),
            'phone' => $usuario->getPhone()
        );
    } else {
        $response['message'] = 'No se encontró el usuario solicitado.';
    }
} else {
    $response['message'] = 'Falta el parámetro "userId".';
}

header('Content-Type: application/json');
echo json_encode($response);

?>