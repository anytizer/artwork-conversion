<?php
namespace slicing;

use \dtos\workdto;
use \slicing\database;

class work extends database
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function clear()
    {
        $clear_sql="DELETE FROM works;";
        
        $statement = $this->database->prepare($clear_sql);
        
        $result = $statement->execute();
        return $result;
    }

    public function create(workdto $work)
    {
        $insert_sql="INSERT INTO works (work_id, work_name, work_desc, work_active) VALUES (:work_id, :work_name, :work_desc, :work_active);";
        
        $statement = $this->database->prepare($insert_sql);
        $statement->bindParam(":work_id", $work->id, SQLITE3_TEXT);
        $statement->bindParam(":work_name", $work->name, SQLITE3_TEXT);
        $statement->bindParam(":work_desc", $work->desc, SQLITE3_TEXT);
        $statement->bindParam(":work_active", $work->active, SQLITE3_TEXT);
        
        $result = $statement->execute();
        return $result;
    }
    
    public function works($project_id="")
    {
        $work_active = "1";
        $works_sql="SELECT * FROM works WHERE work_active=:work_active;";
        
        $statement = $this->database->prepare($works_sql);
        $statement->bindParam(":work_active", $work_active, SQLITE3_TEXT);
        $result = $statement->execute();
        
        $works = [];
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            $workdto = new workdto();
            $workdto->id = $row["work_id"];
            $workdto->name = $row["work_name"];
            $workdto->desc = $row["work_desc"];
            $workdto->active = $row["work_active"];
            
            $works[] = $workdto;
       }
       
       return $works;
    }
    
    public function maintenance()
    {
        //
    }
}