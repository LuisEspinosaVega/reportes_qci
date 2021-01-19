<?php

class User
{
    private $database;

    public $id;
    public $name;
    public $username;
    public $email;
    public $password;
    public $school;

    public function __construct(\Db $database)
    {
        $this->database = $database;
    }

    public function All()
    {
        try {
            $prepare = "SELECT id,name,username,email,school,status FROM users";
            $exec = $this->database->prepare($prepare);
            $exec->execute();

            $users = $exec->fetchAll(PDO::FETCH_ASSOC);

            return $users;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function GetById($id)
    {
        try {
            $prepare = "SELECT id,name,username,email,school FROM users WHERE id = :id AND status = 1";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":id", $id);
            $exec->execute();
            $user = $exec->fetch(PDO::FETCH_ASSOC);

            return $user;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function Create(User $user)
    {
        //Consultar si ya existe el correo ingresado
        try {
            $prepare = "SELECT email,username FROM users WHERE email = :email OR username = :username";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":email", $user->email);
            $exec->bindParam(":username", $user->username);
            $exec->execute();

            $register = $exec->fetch();
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }

        if ($register) {
            return "El correo: " . $register["email"] . " o el usuario: " . $register["username"] . " ya se encuentra en uso.";
        } else {
            try {
                $prepare = 'INSERT INTO users (name,username,email,password,school) VALUES (:name,:username,:email,:password,:school)';
                $exec = $this->database->prepare($prepare);
                $exec->bindParam(":name", $user->name);
                $exec->bindParam(":username", $user->username);
                $exec->bindParam(":email", $user->email);
                $exec->bindParam(":password", $user->password);
                $exec->bindParam(":school", $user->school);

                $exec->execute();

                return "success";
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }
    }

    public function Delete($id)
    {
        try {
            $prepare = "UPDATE users SET status = 0 WHERE id = :id";
            $exec = $this->database->prepare($prepare);
            $exec->bindParam(":id", $id);
            $exec->execute();

            return "success";
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
}
