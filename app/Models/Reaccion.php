<?php

class Reaccion
{
    private $database;

    public $id;
    public $tipo;
    public $id_post_com;
    public $me_gusta;
    public $no_me_gusta;
    public $me_divierte;
    public $me_encanta;
    public $me_enoja;
    public $no_entiend;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function SetReactions($tipo, $id_post_com)
    {
        try {
            $prepare = "INSERT INTO reacciones (tipo,id_post_com) VALUES (:tipo,:id_post_com)";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":tipo", $tipo);
            $exec->bindParam(":id_post_com", $id_post_com);
            $exec->execute();
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function GetReactionsByPost($id)
    {
        try {
            $prepare = "SELECT * FROM reacciones WHERE tipo = 'post' AND id_post_com = :id";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":id", $id);

            $exec->execute();
            $reacciones = $exec->fetch(PDO::FETCH_ASSOC);

            return $reacciones;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function AddReaction($tipo, $idPost)
    {
        //Consultar las reacciones de este post
        try {
            $prepare = "SELECT * FROM reacciones WHERE tipo = 'post' AND reacciones.id_post_com = :id";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":id", $idPost);
            $exec->execute();

            $reacciones = $exec->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
        switch ($tipo) {
            case "meGusta":
                $reacciones["me_gusta"] += 1;
                break;
            case "noMeGusta":
                $reacciones["no_me_gusta"] += 1;
                break;
            case "meDivierte":
                $reacciones["me_divierte"] += 1;
                break;
            case "meEncanta":
                $reacciones["me_encanta"] += 1;
                break;
            case "meEnoja":
                $reacciones["me_enoja"] += 1;
                break;
            case "noEntiendo":
                $reacciones["no_entiendo"] += 1;
                break;
            default:
                break;
        }

        //Guardar de nuevo las reacciones
        $update = "UPDATE reacciones SET me_gusta=:me_gusta,no_me_gusta=:no_me_gusta,me_divierte=:me_divierte,me_encanta=:me_encanta,me_enoja=:me_enoja,no_entiendo=:no_entiendo
                    WHERE tipo = 'post' AND reacciones.id_post_com = :id";
        $execUpdate = $this->database->prepare($update);
        $execUpdate->bindParam(":me_gusta", $reacciones["me_gusta"]);
        $execUpdate->bindParam(":no_me_gusta", $reacciones["no_me_gusta"]);
        $execUpdate->bindParam(":me_divierte", $reacciones["me_divierte"]);
        $execUpdate->bindParam(":me_encanta", $reacciones["me_encanta"]);
        $execUpdate->bindParam(":me_enoja", $reacciones["me_enoja"]);
        $execUpdate->bindParam(":no_entiendo", $reacciones["no_entiendo"]);
        $execUpdate->bindParam(":id", $idPost);

        $execUpdate->execute();

        return "success";
    }
}
