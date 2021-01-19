<?php
session_start();

include_once("Db.php");
include_once("Models/Reporte.php");


//Retornar todos los reportes creados
if(isset($_POST["getAll"])){
    $db = new Db;
    $reporte = new Reporte($db);

    echo json_encode($reporte->All(), true);
}

//Retornar todos los reportes creados por el usuario logeado
if(isset($_POST["getAllByUser"])){
    $id = $_POST["getAllByUser"];
    $db = new Db;
    $reporte = new Reporte($db);

    echo json_encode($reporte->AllByUser($id), true);
}

//Registrar un reporte
if(isset($_POST["newPost"])){
    $db = new Db;
    $reporte = new Reporte($db);

    $reporte->tipoReporte = $_POST["tipoReporte"];
    $reporte->status = $_POST["status"];
    $reporte->description = $_POST["description"];
    $reporte->lat = $_POST["lat"];
    $reporte->long = $_POST["long"];
    $reporte->usuarioId = $_POST["usuarioId"];
    $reporte->fechaAtercado = $_POST["fechaAtercado"];
    $reporte->horaAtercado = $_POST["horaAtercado"];
    $reporte->fechaPost = date("Y-m-d H:i:s");

    echo $reporte->Create($reporte);
}

//Retornar todos los marcadores =3

if(isset($_POST["getMarks"])){
    $db = new Db;
    $reporte = new Reporte($db);

    echo json_encode($reporte->GetMarks(), true);
}