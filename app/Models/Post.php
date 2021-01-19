<?php

class Post
{
    private $database;
    public $titulo;
    public $contenido;
    public $id_usuario;
    public $fecha_creacion;
    public $fecha_edicion;

    public function __construct($database)
    {
        $this->database = $database;
    }

    //Crear un nuevo post
    public function Create(Post $post)
    {
        try {
            $prepare = "INSERT INTO posts (titulo,contenido,id_usuario,fecha_creacion) VALUES (:titulo,:contenido,:id_usuario,:fecha_creacion)";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":titulo", $post->titulo);
            $exec->bindParam(":contenido", $post->contenido);
            $exec->bindParam(":id_usuario", $post->id_usuario);
            $exec->bindParam(":fecha_creacion", $post->fecha_creacion);

            $exec->execute();
            $newPostId = $this->database->lastInsertId();

            return intval($newPostId);
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    //Retornar todos los post
    public function GetAll()
    {
        try {
            $prepare = "SELECT posts.id AS idPost,titulo,contenido,fecha_creacion,username FROM posts INNER JOIN users ON posts.id_usuario = users.id ORDER BY posts.id DESC";
            $exec = $this->database->prepare($prepare);
            $exec->execute();

            $posts = $exec->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function GetAllByPost($id)
    {
        try {
            $prepare = "SELECT posts.id AS idPost,titulo,contenido,fecha_creacion,username FROM posts INNER JOIN users ON posts.id_usuario = users.id WHERE posts.id = :id";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":id", $id);
            $exec->execute();

            $post = $exec->fetch(PDO::FETCH_ASSOC);
            return $post;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function Edit(Post $post, $id)
    {
    }

    public function Delete($id)
    {
    }
}
