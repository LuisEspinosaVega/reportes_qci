<?php
session_start();

include_once("Db.php");
include_once("Models/Post.php");
include_once("Models/Reaccion.php");
include_once("Models/User.php");
include_once("Models/Comentario.php");

$db = new Db;
$post = new Post($db);
$reaccion = new Reaccion($db);
$comentario = new Comentario($db);

//Crear un nuevo post
if (isset($_POST["newPost"])) {
    $post = new Post($db);
    $reaccion = new Reaccion($db);

    //Asignar los valores al objeto post
    $post->titulo = $_POST["titulo"];
    $post->contenido = $_POST["contenido"];
    $post->id_usuario = $_SESSION["id"];
    $post->fecha_creacion = date("Y-m-d H:i:s");

    $newId = $post->Create($post);

    if (gettype($newId) == "integer") {
        $reaccion->SetReactions("post", $newId);

        echo "success";
    } else {
        echo "error";
    }
}

//Devolver todos los post
if (isset($_POST["getAllPost"])) {
    echo json_encode($post->GetAll(), true);
}

//Retornar datos detalle por post
if (isset($_POST["getAllPostByPost"])) {
    $id = $_POST["getAllPostByPost"];
    echo json_encode($post->GetAllByPost($id), true);
}

//Retornar numero de reacciones y comentarios
if (isset($_POST["getReactions"])) {
    $id_post = $_POST["getReactions"];

    $response = array(
        "respuestas" => $comentario->GetCountCommentsByPost($id_post),
        "reacciones" => $reaccion->GetReactionsByPost($id_post)
    );

    echo json_encode($response, true);
}

//Camgiar las reacciones
if(isset($_POST["changeReactions"])){
    $reaccionType = $_POST["tipoReaction"];
    $idPost = $_POST["idPostReactions"];

    echo $reaccion->AddReaction($reaccionType,$idPost);
}
