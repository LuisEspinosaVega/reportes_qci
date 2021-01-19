<?php

class Reporte
{
    private $database;

    public $id;
    public $tipoReporte;
    public $status;
    public $description;
    public $lat;
    public $long;
    public $usuarioId;
    public $fechaAtercado;
    public $horaAtercado;
    public $fechaPost;

    public function __construct(\Db $database)
    {
        $this->database = $database;
    }

    public function AllByUser($id)
    {
        try {
            $prepare = "SELECT * FROM reportes WHERE usuario_id = :id";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":id", $id);
            $exec->execute();

            $reportes = $exec->fetchAll(PDO::FETCH_ASSOC);

            return $reportes;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function All()
    {
        try {
            $prepare = "SELECT * FROM reportes";
            $exec = $this->database->prepare($prepare);
            $exec->execute();

            $reportes = $exec->fetchAll(PDO::FETCH_ASSOC);

            return $reportes;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function Create(Reporte $reporte)
    {
        try {
            $prepare = 'INSERT INTO reportes (usuario_id,latitud,longitud,tipo_reporte,descripcion,status,fecha_atercado,hora_atercado,fecha_post) VALUES (:usuarioId,:lat,:long,:tipoReporte,:description,:status,:fechaAtercado,:horaAtercado,:fechaPost)';
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":usuarioId", $reporte->usuarioId);
            $exec->bindParam(":lat", $reporte->lat);
            $exec->bindParam(":long", $reporte->long);
            $exec->bindParam(":tipoReporte", $reporte->tipoReporte);
            $exec->bindParam(":description", $reporte->description);
            $exec->bindParam(":status", $reporte->status);
            $exec->bindParam(":fechaAtercado", $reporte->fechaAtercado);
            $exec->bindParam(":horaAtercado", $reporte->horaAtercado);
            $exec->bindParam(":fechaPost", $reporte->fechaPost);

            $exec->execute();

            return "success";
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function GetMarks()
    {
        try {
            $prepare = "SELECT latitud,longitud,descripcion FROM reportes";
            $exec = $this->database->prepare($prepare);

            $exec->execute();

            $latLng = $exec->fetchAll(PDO::FETCH_ASSOC);
            return $latLng;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function GetCountByUser($id)
    {
        try {
            $prepare = "SELECT COUNT(*) FROM reportes WHERE usuario_id = :id";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":id", $id);
            $exec->execute();

            $count = $exec->fetchColumn();

            return $count;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
}
