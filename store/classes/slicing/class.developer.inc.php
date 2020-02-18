<?php
namespace slicing;

use \dtos\userdto;
use \slicing\database;

class developer extends database
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function clear()
    {
        $clear_sql="DELETE FROM developers;";
        
        $statement = $this->database->prepare($clear_sql);
        
        $result = $statement->execute();
        return $result;
    }

    public function create(userdto $developer)
    {
        $insert_sql="INSERT INTO developers (developer_id, developer_name, developer_email, developer_password, developer_code, developer_active, developer_onboarded) VALUES (:developer_id, :developer_name, :developer_email, :developer_password, :developer_code, :developer_active, :developer_onboarded);";
        
        $statement = $this->database->prepare($insert_sql);
        $statement->bindParam(":developer_id", $developer->id, SQLITE3_TEXT);
        $statement->bindParam(":developer_name", $developer->name, SQLITE3_TEXT);
        $statement->bindParam(":developer_email", $developer->email, SQLITE3_TEXT);
        $statement->bindParam(":developer_password", $developer->password, SQLITE3_TEXT);
        $statement->bindParam(":developer_code", $developer->code, SQLITE3_TEXT);
        $statement->bindParam(":developer_active", $developer->active, SQLITE3_TEXT);
        $statement->bindParam(":developer_onboarded", $developer->onboarded, SQLITE3_TEXT);
        
        $result = $statement->execute();
        $developer_created = $result!=false;
        return $developer_created;
    }

    public function single($developer_id=""): userdto
    {
        $select_sql="SELECT * FROM developers WHERE developer_id=:developer_id LIMIT 1;";

        $statement = $this->database->prepare($select_sql);
        $statement->bindParam(":developer_id", $developer_id, SQLITE3_TEXT);

        $result = $statement->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);

        $userdto = new userdto();
        $userdto->id = $row["developer_id"];
        $userdto->name = $row["developer_name"];
        $userdto->email = $row["developer_email"];
        $userdto->password = $row["developer_password"];
        $userdto->code = $row["developer_code"];
        $userdto->active = $row["developer_active"];
        $userdto->onboarded = $row["developer_onboarded"];

        return $userdto;
    }

    public function activate($developer_id="", $developer_code=""): bool
    {
        $flag_sql="UPDATE developers SET developer_active=1, developer_onboarded=1 WHERE developer_id=:developer_id AND developer_code=:developer_code;";
        $statement = $this->database->prepare($flag_sql);
        $statement->bindParam(":developer_id", $developer_id, SQLITE3_TEXT);
        $statement->bindParam(":developer_code", $developer_code, SQLITE3_TEXT);
        $result = $statement->execute();

        return $result!=false;
    }
    
    public function recent()
    {
        $developers = [];
        
        $developers_sql="SELECT * FROM developers LIMIT 500;";
        $statement = $this->database->prepare($developers_sql);
        $result = $statement->execute();
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $userdto = new userdto();
            $userdto->id = $row["developer_id"];
            $userdto->name = $row["developer_name"];
            $userdto->email = $row["developer_email"];
            $userdto->password = $row["developer_password"];
            $userdto->code = $row["developer_code"];
            $userdto->active = $row["developer_active"];
            $userdto->onboarded = $row["developer_onboarded"];
            
            $developers[] = $userdto;
        }
        
        return $developers;
    }
    
    public function flag(userdto $developer)
    {
        // get current flag
        // if 1, 0
        // if 0, 1
        // update flag
        $flag_sql="update developers set developer_active = CASE developer_active
           WHEN '0'
               THEN '1'
           ELSE '0'
       END
       where developer_id=:developer_id;";
        $statement = $this->database->prepare($flag_sql);
        $statement->bindParam(":developer_id", $developer->id, SQLITE3_TEXT);
        $result = $statement->execute();
        return $result;
    }
    
    public function onboarded(userdto $developer)
    {
        // get current onboarded flag
        // if 1, 0
        // if 0, 1
        // update onboarded flag
        $flag_sql="UPDATE developers SET developer_onboarded = CASE developer_onboarded
           WHEN '0'
               THEN '1'
           ELSE '0'
       END
       WHERE developer_id=:developer_id;";
       #die($flag_sql);
        $statement = $this->database->prepare($flag_sql);
        $statement->bindParam(":developer_id", $developer->id, SQLITE3_TEXT);
        $result = $statement->execute();
        return $result;
    }
    
    public function maintenance()
    {
        //
    }
}