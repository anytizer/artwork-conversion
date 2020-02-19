<?php
namespace slicing;

use \slicing\database;
use \slicing\project;
use \slicing\developer;
use \slicing\customer;
use \slicing\fileuploader;

class maintenance extends database
{
    public function __construct()
    {
        parent::__construct();
    }
    
    private function reinstall_table($table="")
    {
        $this->database->query("DROP TABLE IF EXISTS `{$table}`;");

        $sql = file_get_contents(__ROOT__."/store/database/{$table}.sql");
        $this->database->query($sql);
    }

    public function reinstall()
    {
        $this->reinstall_table("admins");
        $this->reinstall_table("artworks");
        $this->reinstall_table("customers");
        $this->reinstall_table("developers");
        $this->reinstall_table("estimations");
        $this->reinstall_table("info"); // contains data
        $this->reinstall_table("payments");
        $this->reinstall_table("projects");
        $this->reinstall_table("statuses"); // contains data
        $this->reinstall_table("terminations");
        $this->reinstall_table("works"); // contains data
    }
    
    public function maintain()
    {
        $maintenance = [];

        $project = new project();
        $maintenance["project"] = $project->maintenance();

        $developer = new developer();
        $maintenance["developer"] = $developer->maintenance();

        $customer = new customer();
        $maintenance["customer"] = $customer->maintenance();

        # Now, vacuum the database
        # Cleanup the uploaded files
        $fu = new fileuploader();
        $maintenance["artworks"] = $fu->maintenance();
        
        return $maintenance;
    }

    # @todo Only on demo servers
    public function borrow($customer_id=""): bool
    {
        $customer_id = id($customer_id);
        $borrow_sql="UPDATE projects SET customer_id=:customer_id;";
        
        $statement = $this->database->prepare($borrow_sql);
        $statement->bindParam(":customer_id", $customer_id, SQLITE3_TEXT);
        $result = $statement->execute();
        
        return $result != false;
        
    }
}
