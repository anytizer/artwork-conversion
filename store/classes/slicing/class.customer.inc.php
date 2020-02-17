<?php
namespace slicing;

use \dtos\userdto;
use \dtos\logindto;
use \slicing\database;

class customer extends database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(userdto $customer): bool
    {
        if(!$this->unique($customer->email))
        {
            return false;
        }
        $insert_sql="INSERT INTO customers (customer_id, customer_name, customer_email, customer_password, customer_code, customer_active) VALUES (:customer_id, :customer_name, :customer_email, :customer_password, :customer_code, :customer_active);";
        
        $statement = $this->database->prepare($insert_sql);
        $statement->bindParam(":customer_id", $customer->id, SQLITE3_TEXT);
        $statement->bindParam(":customer_name", $customer->name, SQLITE3_TEXT);
        $statement->bindParam(":customer_email", $customer->email, SQLITE3_TEXT);
        $statement->bindParam(":customer_password", $customer->password, SQLITE3_TEXT);
        $statement->bindParam(":customer_code", $customer->code, SQLITE3_TEXT);
        $statement->bindParam(":customer_active", $customer->active, SQLITE3_TEXT);

        $result = $statement->execute();
        return $result!=false;
    }
    
    private function unique($customer_email=""): bool
    {
        $uniqueness_sql = "SELECT * FROM customers WHERE customer_email=:customer_email;";
        $statement = $this->database->prepare($uniqueness_sql);
        $statement->bindParam(":customer_email", $customer_email, SQLITE3_TEXT);
        # @todo Unique email address using the database lookup
        # if email exists: return false
        $exists = false;
        return !$exists;
    }
    
    public function maintenance()
    {
        //
    }
    
    public function activate($customer_email="", $customer_code=""): bool
    {
        # @ToDo bind to single transaction
        # @todo Reset the code
        $customer_active = "1";
        $activate_sql="
UPDATE customers SET
    customer_active=:customer_active,
    customer_code=:customer_new_code
WHERE
    customer_email=:customer_email
    AND customer_code=:customer_code
;";
        $customer_new_code = md5(password_plain());
        $statement = $this->database->prepare($activate_sql);
        $statement->bindParam(":customer_email", $customer_email, SQLITE3_TEXT);
        $statement->bindParam(":customer_new_code", $customer_new_code, SQLITE3_TEXT);
        $statement->bindParam(":customer_code", $customer_code, SQLITE3_TEXT);
        $statement->bindParam(":customer_active", $customer_active, SQLITE3_TEXT);
        $result = $statement->execute();
        return $result!=false;
    }
    
    public function login(logindto $login): bool
    {
        # @todo Hash match password
        $customer_active = "1";
        $login_sql="SELECT COUNT(*) total FROM customers WHERE customer_email=:customer_email AND customer_active=:customer_active;";
        $statement = $this->database->prepare($login_sql);
        $statement->bindParam(":customer_email", $login->email, SQLITE3_TEXT);
        $statement->bindParam(":customer_active", $customer_active, SQLITE3_TEXT);
        $result = $statement->execute();
        
        # hash match
        # AND customer_password=:customer_password

        $row = $result->fetchArray(SQLITE3_ASSOC);
        return $row["total"] == 1;
    }
    
    public function single($customer_id=""): userdto
    {
        $customer_id = id($customer_id);
        $customer_active = "1";

        $get_sql="SELECT * FROM customers WHERE customer_id=:customer_id LIMIT 1;";
        $statement = $this->database->prepare($get_sql);
        $statement->bindParam(":customer_id", $customer_id, SQLITE3_TEXT);
        $statement->bindParam(":customer_active", $customer_active, SQLITE3_TEXT);
        $result = $statement->execute();
        
        $row = $result->fetchArray(SQLITE3_ASSOC);
        #print_r($row);
        
        $userdto = new userdto();
        $userdto->id = $row["customer_id"];
        $userdto->name = $row["customer_name"];
        $userdto->email = $row["customer_email"];
        $userdto->password = $row["customer_password"];
        $userdto->code = $row["customer_code"];
        $userdto->active = $row["customer_active"];

        return $userdto;
    }
}