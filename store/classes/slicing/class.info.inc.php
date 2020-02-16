<?php
namespace slicing;

use dtos\infodto;
use slicing\database;

class info extends database
{
    public function clear()
    {
        $clear_sql="DELETE FROM info;";
        
        $statement = $this->database->prepare($clear_sql);
        
        $result = $statement->execute();
        return $result;
    }
    
    public function getall(): array
    {
        $info_sql ="SELECT * FROM info;";
        $statement = $this->database->prepare($info_sql);
        $result = $statement->execute();
        
        $infos = [];
        while($info = $result->fetchArray(SQLITE3_ASSOC))
        {
            $infodto = new infodto();
            $infodto->id = $info["info_id"];
            $infodto->company = $info["info_company"];
            $infodto->phone = $info["info_phone"];
            $infodto->email = $info["info_email"];
            $infodto->website = $info["info_website"];
            $infodto->address = $info["info_address"];
            $infodto->registration = $info["info_registration"];
            
            $infos[] = $infodto;
        }
        
        return $infos;
    }
    
    public function create(infodto $infodto): bool
    {
        $insert_sql="
INSERT INTO info (
    info_id, info_company, info_phone, info_email,
    info_website, info_address, info_registration
) VALUES (
    :info_id, :info_company, :info_phone, :info_email,
    :info_website, :info_address, :info_registration
);";
        $statement = $this->database->prepare($insert_sql);
        $statement->bindParam(":info_id", $infodto->id, SQLITE3_TEXT);
        $statement->bindParam(":info_company", $infodto->company, SQLITE3_TEXT);
        $statement->bindParam(":info_phone", $infodto->phone, SQLITE3_TEXT);
        $statement->bindParam(":info_email", $infodto->email, SQLITE3_TEXT);
        $statement->bindParam(":info_website", $infodto->website, SQLITE3_TEXT);
        $statement->bindParam(":info_address", $infodto->address, SQLITE3_TEXT);
        $statement->bindParam(":info_registration", $infodto->registration, SQLITE3_TEXT);
        
        $result = $statement->execute();
        $created = $result!=false;
        
        return $created;
    }
}
