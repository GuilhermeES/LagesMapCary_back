<?php

namespace MapcityBack\Controller;
use MapcityBack\Models\IncidentsModels;
use PDOException;

class IncidentsController
{
    public $IncidentsModels;

    public function __construct()
    {
        $this->IncidentsModels = new IncidentsModels();
    }

    public function create() {
        $input = file_get_contents('php://input');
        $dataDecode = json_decode($input, true);

        $data = [
            'date' => trim($dataDecode['date']),
            'title' => trim($dataDecode['title']),
            'type' => trim($dataDecode['type']),
            'gravity' => trim($dataDecode['gravity']),
            'description' => trim($dataDecode['description']),
            'lat' => trim($dataDecode['lat']),
            'longt' => trim($dataDecode['longt']),
            'user_id' => trim($dataDecode['user_id'])
        ];
        
        $emptyFields = array_filter($data, function ($value) {
            return empty($value);
        });

        try {
            if (!empty($emptyFields)) {
                header("HTTP/1.0 404");
                echo json_encode(["message" => "Todos os campos são obrigatórios."]);
                return false;
            }

            $createIncident = $this->IncidentsModels->create(...array_values($data));
            
            if($createIncident) {
                header("HTTP/1.0 200");
                echo json_encode(["message" => "Incidente criado com sucesso!"]);
            }
            else{
                header("HTTP/1.0 500");
                echo json_encode(["message" => "Usuário inválido"]);
            }
            
        } catch (PDOException $e) {
            header("HTTP/1.0 500");
            echo json_encode(["message" => "Erro" . $e->getMessage()]);
        }
    }
}
