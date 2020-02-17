<?php
namespace slicing;

use \dtos\userdto;
use \dtos\logindto;
use \slicing\database;

class admin extends database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(userdto $admin): bool
    {
        $insert_sql="INSERT INTO admins (admin_id, admin_name, admin_email, admin_password, admin_code, admin_active) VALUES (:admin_id, :admin_name, :admin_email, :admin_password, :admin_code, :admin_active);";

        $statement = $this->database->prepare($insert_sql);
        $statement->bindParam(":admin_id", $admin->id, SQLITE3_TEXT);
        $statement->bindParam(":admin_name", $admin->name, SQLITE3_TEXT);
        $statement->bindParam(":admin_email", $admin->email, SQLITE3_TEXT);
        $statement->bindParam(":admin_password", $admin->password, SQLITE3_TEXT);
        $statement->bindParam(":admin_code", $admin->code, SQLITE3_TEXT);
        $statement->bindParam(":admin_active", $admin->active, SQLITE3_TEXT);

        $result = $statement->execute();
        $admin_created = $result!=false;
        return $admin_created;
    }
}