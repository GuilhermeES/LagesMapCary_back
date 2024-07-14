<?php

namespace MapcityBack\Controller;
use MapcityBack\Models\UserModel;
use PDOException;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
            $existEmail = $this->userModel->existEmail($email);

            if ($existEmail) {
                header("HTTP/1.0 409");
                echo json_encode(["message" => "E-mail já cadastrado!"]);
                return false;
            }

            $this->userModel->create($email, $password, $nome);

            header("HTTP/1.0 200");
            echo json_encode(["message" => "Usuário criado com sucesso!"]);

        } catch (PDOException $e) {
            
            header("HTTP/1.0 500");
            echo json_encode(["message" => "Erro" . $e->getMessage()]);
        }
    }
}
