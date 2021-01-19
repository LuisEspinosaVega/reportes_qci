<?php

session_start();

include_once("Db.php");
include_once("Models/Comentario.php");

$db = new Db;
$comentario = new Comentario($db);

// Guardar el nuevo comentario
if(isset($_POST["idDetail"])){
    $comentario->id_post = $_POST["idDetail"];
    $comentario->id_usuario = $_SESSION["id"];
    $comentario->fecha_creacion = date("Y-m-d H:i:s");
    $comentario->contenido = $_POST["commentContent"];

    echo $comentario->Create($comentario);
}

//Retornar los comentarios
if(isset($_POST["getPostByPostId"])){
    $id_comment = $_POST["getPostByPostId"];
    // echo $comentario->GetAllCommentsByPost($id_comment);
    echo json_encode($comentario->GetAllCommentsByPost($id_comment));
}