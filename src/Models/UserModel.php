<?php

namespace MapcityBack\Models;
use MapcityBack\Database\Database;
use PDO;

class UserModel
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function existUser($user_id) {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchColumn();
    }

    public function existEmail($email) {
        $query = $this->pdo->prepare("SELECT * FROM users where email = :email");
        $query->bindParam(":email", $email);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function create($email, $password, $nome){
        $query = $this->pdo->prepare("INSERT INTO users (email, password, nome) VALUES (:email, :password, :nome)");
        $query->bindParam(":email", $email);
        $query->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $query->bindParam(":nome", $nome);
        return $query->execute();
    }
}
