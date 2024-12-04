<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include "../../connection.php";
include "../Usuario-class.php";

$response = array(
    'success' => false,
    'message' => 'No se pudo editar el usuario.'
);

$data = json_decode(file_get_contents('php://input'), true);

if($data){
    if(isset($data['userId'], $data['name'], $data['username'], $data['email'], $data['phone'])) {
        $userId = $data['userId'];
        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];
        $phone = $data['phone'];

        $usuario = new Usuario($connection, $userId);

        if($usuario->update($name, $username, $email, $phone)) {
            $response = [
                'success' => true,
                'message' => 'Usuario actualizado exitosamente.'
            ];
        } else {
            $response['message'] = 'Error al actualizar el usuario.';
        }
    } else {
        $response['message'] = 'Faltan datos en la solicitud.';
    }
}

header('Content-Type: application/json');
echo json_encode($response);

?>