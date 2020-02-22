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

    public function get_all_active_customers()
    {
        $customers = [];

        $all_sql="
        SELECT
	c.customer_id id,
	c.customer_name `name`,
	c.customer_email email,
	COUNT(*) total
FROM customers c
INNER JOIN projects p ON p.customer_id = c.customer_id
GROUP BY
	c.customer_id
;";
        $all_sql = "SELECT c.customer_id id, c.customer_name `name`, c.customer_email email, 0 total FROM customers c;";

        $statement = $this->database->prepare($all_sql);
        $result = $statement->execute();
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $userdto = new userdto();
            $userdto->id = $row["id"];
            $userdto->name = $row["name"];
            $userdto->email = $row["email"];
            $userdto->password = "";
            $userdto->code = "";
            $userdto->active = $row["active"];

            $userdto->total = $row["total"];

            $customers[] = $userdto;
        }

        return $customers;
    }
    
    public function maintenance()
    {
        // delete from customers where customer_id not in (select customer_id from projects);
    }
    
    public function activate($customer_id="", $customer_code=""): bool
    {
        # @ToDo bind to single transaction
        # @todo Reset the code
        $customer_active = "1";
        $customer_new_code = md5(password_plain());

        $activate_sql="
UPDATE customers SET
    customer_active=:customer_active,
    customer_code=:customer_new_code
WHERE
    -- customer_email=:customer_email
    customer_id=:customer_id
    AND customer_code=:customer_code
;";
        $statement = $this->database->prepare($activate_sql);
        #$statement->bindParam(":customer_email", $customer_email, SQLITE3_TEXT);
        $statement->bindParam(":customer_id", $customer_id, SQLITE3_TEXT);
        $statement->bindParam(":customer_new_code", $customer_new_code, SQLITE3_TEXT);
        $statement->bindParam(":customer_code", $customer_code, SQLITE3_TEXT);
        $statement->bindParam(":customer_active", $customer_active, SQLITE3_TEXT);
        $result = $statement->execute();

        return $this->database->changes() == 1;
        // return $result!=false;me
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

        $password_verified = false;
        if($row["total"] == 1)
        {
            $customerdto = $this->details_by_email($login->email);
            //print_r($customerdto);
            $password_verified = password_verify($login->password, $customerdto->password);
        }

        return $password_verified;
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

    # For logged in customers
    public function details_by_email($customer_email=""): userdto
    {
        $customer_active = "1";

        $get_sql="SELECT * FROM customers WHERE customer_email=:customer_email AND customer_active=:customer_active LIMIT 1;";
        $statement = $this->database->prepare($get_sql);
        $statement->bindParam(":customer_email", $customer_email, SQLITE3_TEXT);
        $statement->bindParam(":customer_active", $customer_active, SQLITE3_TEXT);
        $result = $statement->execute();

        $row = $result->fetchArray(SQLITE3_ASSOC);

        $userdto = new userdto();
        $userdto->id = $row["customer_id"];
        $userdto->name = $row["customer_name"];
        $userdto->email = $row["customer_email"];
        $userdto->password = $row["customer_password"];
        $userdto->code = $row["customer_code"];
        $userdto->active = $row["customer_active"];

        return $userdto;
    }

    public function statistics(userdto $customerdto)
    {
        $projects_counter_sql="SELECT COUNT(*) total, SUM(project_budget) dues, SUM(project_paid) paid FROM projects WHERE customer_id=:customer_id;";
        $statement = $this->database->prepare($projects_counter_sql);
        $statement->bindParam(":customer_id", $customerdto->id, SQLITE3_TEXT);
        $result = $statement->execute();

        $statistics = $result->fetchArray(SQLITE3_ASSOC);

//        $statistics = [
//            "total" => 89,
//            "dues" => 99.99,
//            "paid" => 100.00,
//        ];

        return $statistics;
    }
}