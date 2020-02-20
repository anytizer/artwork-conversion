<?php
namespace slicing;

use \dtos\idnamedto;
use \slicing\database;

class status extends database
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function clear()
    {
        $clear_sql="DELETE FROM statuses;";
        
        $statement = $this->database->prepare($clear_sql);
        
        $result = $statement->execute();
        return $result;
    }

    public function create(idnamedto $statusdto): bool
    {
        $insert_sql="INSERT INTO statuses (status_id, status_name) VALUES (:status_id, :status_name);";
        
        $statement = $this->database->prepare($insert_sql);
        $statement->bindParam(":status_id", $statusdto->id, SQLITE3_TEXT);
        $statement->bindParam(":status_name", $statusdto->name, SQLITE3_TEXT);
        
        $result = $statement->execute();
        $status_created = $result!=false;
        return $status_created;
    }

    public function single($status_id=""): idnamedto
    {
        $select_sql="SELECT * FROM statuses WHERE status_id=:status_id LIMIT 1;";

        $statement = $this->database->prepare($select_sql);
        $statement->bindParam(":status_id", $status_id, SQLITE3_TEXT);

        $result = $statement->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);

        $statusdto = new idnamedto();
        $statusdto->id = $row["status_id"];
        $statusdto->name = $row["status_name"];

        return $statusdto;
    }

    public function maintenance()
    {
        //
    }
}