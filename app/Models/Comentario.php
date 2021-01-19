<?php

class Comentario
{
    private $database;

    public $id_post;
    public $id_usuario;
    public $fecha_creacion;
    public $contenido;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function Create(Comentario $comentario)
    {
        try {
            $prepare = "INSERT INTO comentarios (id_post,id_usuario,fecha_creacion,contenido) VALUES (:id_post,:id_usuario,:fecha_creacion,:contenido)";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":id_post", $comentario->id_post);
            $exec->bindParam(":id_usuario", $comentario->id_usuario);
            $exec->bindParam(":fecha_creacion", $comentario->fecha_creacion);
            $exec->bindParam(":contenido", $comentario->contenido);

            $exec->execute();

            return "success";
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function GetAllCommentsByPost($id)
    {
        $prepare = "SELECT contenido,fecha_creacion,users.username AS name FROM comentarios INNER JOIN users ON id_usuario = users.id WHERE comentarios.id_post = :id";
        $exec = $this->database->prepare($prepare);
        $exec->bindParam(":id", $id);
        $exec->execute();

        $comentarios = $exec->fetchAll(PDO::FETCH_ASSOC);

        return $comentarios;
    }

    public function GetCountCommentsByPost($id)
    {
        $prepare = "SELECT COUNT(*) FROM comentarios WHERE comentarios.id_post = :id";
        $exec = $this->database->prepare($prepare);
        $exec->bindParam(":id", $id);
        $exec->execute();

        $count = $exec->fetchColumn();

        return $count;
    }
}
