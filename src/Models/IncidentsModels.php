<?php

namespace MapcityBack\Models;
use MapcityBack\Database\Database;
use MapcityBack\Models\UserModel;

class IncidentsModels
{
    public $pdo;
    public $userModel;

    public function __construct()
    {
        $this->pdo = Database::connection();
        $this->userModel = new userModel();
    }

    public function create($date, $title, $type, $gravity, $description, $lat, $longt, $user_id) {
       if($this->userModel->existUser($user_id)) {
            $query = $this->pdo->prepare("INSERT INTO incidents (date, title, type, gravity, description, lat, longt, user_id) 
                VALUES (:date, :title, :type, :gravity, :description, :lat, :longt, :user_id)");
            $query->bindParam(":date", $date);      
            $query->bindParam(":title", $title);
            $query->bindParam(":type", $type);
            $query->bindParam(":gravity", $gravity);
            $query->bindParam(":description", $description);     
            $query->bindParam(":lat", $lat);      
            $query->bindParam(":longt", $longt);         
            $query->bindParam(":user_id", $user_id);    
            return $query->execute();    
       }
       else{
            return false;
       }
    }
}
