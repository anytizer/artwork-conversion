<?php
namespace slicing;

use demo\provider;
use \slicing\database;

class hook extends database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function mark_project_paid($project_id="", $payment_amount="", $payment_reference="", $payment_from=""): bool
    {
        $insert_sql="
INSERT INTO payments (
    payment_id, project_id, payment_reference, payment_on, payment_amount,
    payment_from
) VALUES (
    :payment_id, :project_id, :payment_reference, :payment_on, :payment_amount,
    :payment_from
);";
        #echo $insert_sql;

        $provider = new provider();
        $payment_id = $provider->id();
        $payment_on = date("Y-m-d H:i:s");
        $statement = $this->database->prepare($insert_sql);
        $statement->bindParam(":payment_id", $payment_id, SQLITE3_TEXT);
        $statement->bindParam(":project_id", $project_id, SQLITE3_TEXT);
        $statement->bindParam(":payment_reference", $payment_reference, SQLITE3_TEXT);
        $statement->bindParam(":payment_on", $payment_on, SQLITE3_TEXT);
        $statement->bindParam(":payment_amount", $payment_amount, SQLITE3_TEXT);
        $statement->bindParam(":payment_from", $payment_from, SQLITE3_TEXT);
        #print_r($statement);
       
        $result = $statement->execute();
        
        $paid_sql="UPDATE projects SET project_budget=0.00, project_paid=project_paid+:payment_amount WHERE project_id=:project_id;";
        $statement = $this->database->prepare($paid_sql);
        $statement->bindParam(":project_id", $project_id, SQLITE3_TEXT);
        $statement->bindParam(":payment_amount", $payment_amount, SQLITE3_TEXT);
        $result = $statement->execute();
        
        return $result!=false;
    }
}
