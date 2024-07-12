<?php

namespace MapcityBack\Controller;
use MapcityBack\Database\Database;
use PDOException;

class UserController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function register() {
    
        $input = file_get_contents('php://input');
        $dataDecode = json_decode($input, true);

        $email = $dataDecode['email'];
        $nome = $dataDecode['nome'];
        $password = $dataDecode['password'];

        if (empty($email) || empty($nome) || empty($password)) {
            header("HTTP/1.0 404");
            echo json_encode(["message" => "Todos os campos são obrigatórios."]);
            return false;
        }

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $emailExists = $stmt->fetchColumn();

            if ($emailExists) {
                header("HTTP/1.0 409");
                echo json_encode(["message" => "E-mail já cadastrado!"]);
                return false;
            }

            $stmt = $this->pdo->prepare("INSERT INTO users (email, nome, password) VALUES (:email, :nome, :password)");

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT)); 

            $stmt->execute();

            header("HTTP/1.0 200");
            echo json_encode(["message" => "Usuário criado com sucesso!"]);

        } catch (PDOException $e) {
            
            header("HTTP/1.0 500");
            echo json_encode(["message" => "Erro" . $e->getMessage()]);
        }
    }
}
