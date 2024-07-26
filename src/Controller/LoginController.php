<?php

namespace MapcityBack\Controller;
use MapcityBack\Models\UserModel;
use MapcityBack\helpers\Token;

class LoginController
{
    public $userModel;
    public $token;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->token = new Token();
    }

    public function login() {
        $input = file_get_contents('php://input');
        $dataDecode = json_decode($input, true);

        $email = $dataDecode['email'];
        $password = $dataDecode['password'];

        $existUser = $this->userModel->existEmail($email);
    
        if($existUser) {
            $passwordVerify = password_verify($password, $existUser['password']);

            if($passwordVerify) {         
                header("HTTP/1.0 200");
                echo json_encode([
                    'success' => true,
                    'token' => $this->token->generateToken(),
                    'expires_in' => $this->token->expire(),
                    'data' => [
                        'id' => $existUser['id'],
                        'registration_date' => $existUser['registration_date'],
                        'nome' => $existUser['nome'],
                        'email' => $existUser['email'],
                    ]
                ]);
            }
            else{
                header("HTTP/1.0 500");
                echo json_encode(["message" => "Usuário não encontrado"]);
            }
        }
        else{
            header("HTTP/1.0 500");
            echo json_encode(["message" => "Usuário não encontrado"]);
        }
    }
}
