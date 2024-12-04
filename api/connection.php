<?php

    //datos de conexión
    $servername="localhost";
    $username="thalia";
    $password="1234";
    $database="proyecto_inicial_db";

    //crear la conexión
    $connection = mysqli_connect($servername, $username, $password, $database);
    mysqli_set_charset($connection, "utf8");

    //comprobar conexión
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>