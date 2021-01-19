<?php
session_start();


include_once("Db.php");
include_once("Models/User.php");
include_once("Models/Reporte.php");

//Jalar todos los datos XD
if (isset($_POST["getUsers"])) {

    $db = new Db;
    $users = new User($db);

    echo json_encode($users->All(), true);
}

//Iniciar sesion
if (isset($_POST["login"])) {
    $user = $_POST["username"];
    $password = $_POST["password"];

    $db = new Db;

    try {
        $query = "SELECT name,id FROM users WHERE (username = :username OR email = :email) AND password = :password AND status = 1";
        $exec = $db->prepare($query);
        $exec->bindParam(':username', $user);
        $exec->bindParam(':email', $user);
        $exec->bindParam(':password', $password);
        $exec->execute();
        $usuario = $exec->fetch();
        if ($usuario) {
            $_SESSION["name"] = $usuario["name"];
            $_SESSION["id"] = $usuario["id"];
            if ($usuario["id"] == 1) {
                $_SESSION["isAdmin"] = true;
            } else {
                $_SESSION["isAdmin"] = false;
            }

            echo "success";
        } else {
            echo "Credenciales incorrectas, intentalo de nuevo.";
        }
    } catch (PDOException $e) {
        throw 'Error: ' . $e->getMessage();
    }
}

//Retornar datos del usuario logeado
if (isset($_POST["userId"])) {
    $id = $_POST["userId"];
    $db = new Db;
    $user = new User($db);
    $reporte = new Reporte($db);

    $response = array(
        "user" => $user->GetById($id),
        "registros" => $reporte->GetCountByUser($id)
    );
    echo json_encode($response, true);
}


//Registrar un usuario
if(isset($_POST["register"])){
    $db = new Db;
    $user = new User($db);

    $user->name = $_POST["name"];
    $user->username = $_POST["username"];
    $user->email = $_POST["email"];
    $user->password = $_POST["password"];
    $user->school = $_POST["school"];

    echo $user->Create($user);
}

//Desactivar usuario XD
if(isset($_POST["userDelete"])){
    $db = new Db;
    $user = new User($db);

    $id = $_POST["userDelete"];
    echo $user->Delete($id);
}