<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include "../../connection.php";
include "../Usuario-class.php";

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


$response = array(
    'success' => false,
    'message' => 'No se pudo obtener la información de la canción.',
    'data' => array()
);

$objetoUsuario = new Usuario($connection);
$usuario = $objetoUsuario->getAll();

if ($usuario && count($usuario) > 0) {
    $response['success'] = true;
    $response['message'] = 'Usuarios obtenidos.';
    $response['data'] = $usuario;
} else {
    $response['message'] = 'No se encontraron usuarios.';
}

header('Content-Type: application/json');
echo json_encode($response);
