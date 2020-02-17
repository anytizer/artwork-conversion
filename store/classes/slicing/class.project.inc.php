<?php
namespace slicing;

use \dtos\userdto;
use \dtos\projectdto;
use \dtos\estimationdto;
use \dtos\paymentdto;
use \dtos\terminationdto;
use \dtos\filedto;
use \slicing\database;
use anytizer\guid;

class project extends database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(userdto $customer, projectdto $project)
    {
        $insert_sql="INSERT INTO projects (project_id, customer_id, project_name, project_date, project_budget, project_paid, project_active, project_terminated) VALUES (:project_id, :customer_id, :project_name, :project_date, :project_budget, :project_paid, :project_active, :project_terminated);";
        
        $statement = $this->database->prepare($insert_sql);
        $statement->bindParam(":project_id", $project->id, SQLITE3_TEXT);
        $statement->bindParam(":customer_id", $customer->id, SQLITE3_TEXT);
        $statement->bindParam(":project_name", $project->name, SQLITE3_TEXT);
        $statement->bindParam(":project_date", $project->date, SQLITE3_TEXT);
        $statement->bindParam(":project_budget", $project->budget, SQLITE3_TEXT);
        $statement->bindParam(":project_paid", $project->paid, SQLITE3_TEXT);
        $statement->bindParam(":project_active", $project->active, SQLITE3_TEXT);
        $statement->bindParam(":project_terminated", $project->terminated, SQLITE3_TEXT);
        
        $result = $statement->execute();
        return $result;
    }
    
    public function attach_artwork(projectdto $project, $files=[])
    {
        foreach($files as $file)
        {
            $insert_sql="INSERT INTO artworks (artwork_id, project_id, artwork_name, artwork_type, artwork_error, artwork_size, artwork_path, artwork_active, artwork_date) VALUES (:artwork_id, :project_id, :artwork_name, :artwork_type, :artwork_error, :artwork_size, :artwork_path, :artwork_active, :artwork_date);";

            $statement = $this->database->prepare($insert_sql);
            $statement->bindParam(":artwork_id", $file->id, SQLITE3_TEXT);
            $statement->bindParam(":project_id", $project->id, SQLITE3_TEXT);
            $statement->bindParam(":artwork_name", $file->name, SQLITE3_TEXT);
            $statement->bindParam(":artwork_type", $file->type, SQLITE3_TEXT);
            $statement->bindParam(":artwork_error", $file->error, SQLITE3_TEXT);
            $statement->bindParam(":artwork_size", $file->size, SQLITE3_TEXT);
            $statement->bindParam(":artwork_path", $file->path, SQLITE3_TEXT);
            $statement->bindParam(":artwork_active", $file->active, SQLITE3_TEXT);
            $statement->bindParam(":artwork_date", $file->date, SQLITE3_TEXT);

            $result = $statement->execute();
        }

        return count($files);
    }
    
    public function dues($customer_id="")
    {
        $projects = [];

        $projects_sql="SELECT * FROM projects WHERE customer_id=:customer_id AND project_budget!=0 ORDER BY project_date DESC LIMIT 100;";
        $statement = $this->database->prepare($projects_sql);
        $statement->bindParam(":customer_id", $customer_id, SQLITE3_TEXT);
        
        $result = $statement->execute();
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $projectdto = new projectdto();
            $projectdto->id = $row["project_id"];
            $projectdto->name = $row["project_name"];
            $projectdto->budget = $row["project_budget"];
            $projectdto->paid = $row["project_paid"];
            $projectdto->date = $row["project_date"];
            $projectdto->active = $row["project_active"];
            $projectdto->terminated = $row["project_terminated"];
            
            $projects[] = $projectdto;
        }
        
        return $projects;
    }
    
    public function terminated($customer_id="")
    {
        $projects = [];

        $projects_sql="SELECT * FROM projects WHERE project_terminated!=0 LIMIT 100;";
        $statement = $this->database->prepare($projects_sql);
        #$statement->bindParam(":customer_id", $customer_id, SQLITE3_TEXT);
        
        $result = $statement->execute();
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $projectdto = new projectdto();
            $projectdto->id = $row["project_id"];
            $projectdto->name = $row["project_name"];
            $projectdto->budget = $row["project_budget"];
            $projectdto->paid = $row["project_paid"];
            $projectdto->date = $row["project_date"];
            $projectdto->active = $row["project_active"];
            $projectdto->terminated = $row["project_terminated"];
            
            $projects[] = $projectdto;
        }
        
        return $projects;
    }
    
    # @todo Recent projects of a logged in customer only
    public function recent($customer_id="")
    {
        $projects = [];

        $projects_sql="SELECT * FROM projects WHERE customer_id=:customer_id ORDER BY project_date DESC LIMIT 100;"; # order by project on desc, limit by sessioned customer
        $statement = $this->database->prepare($projects_sql);
        $statement->bindParam(":customer_id", $customer_id, SQLITE3_TEXT);
        
        $result = $statement->execute();
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $projectdto = new projectdto();
            $projectdto->id = $row["project_id"];
            $projectdto->name = $row["project_name"];
            $projectdto->budget = $row["project_budget"];
            $projectdto->paid = $row["project_paid"];
            $projectdto->date = $row["project_date"];
            $projectdto->active = $row["project_active"];
            $projectdto->terminated = $row["project_terminated"];
            
            $projects[] = $projectdto;
        }
        
        return $projects;
    }
    
    public function recent_admin()
    {
        $projects = [];

        $projects_sql="SELECT * FROM projects WHERE project_terminated=0 ORDER BY project_date DESC LIMIT 500;"; # order by project on desc, limit by sessioned customer
        $statement = $this->database->prepare($projects_sql);
        
        $result = $statement->execute();
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $projectdto = new projectdto();
            $projectdto->id = $row["project_id"];
            $projectdto->name = $row["project_name"];
            $projectdto->budget = $row["project_budget"];
            $projectdto->paid = $row["project_paid"];
            $projectdto->date = $row["project_date"];
            $projectdto->active = $row["project_active"];
            $projectdto->terminated = $row["project_terminated"];
            
            $projects[] = $projectdto;
        }
        
        return $projects;
    }
    
    # @todo Projects that are not estimated yet
    public function to_estimate()
    {
        $projects = [];

        $projects_sql="SELECT * FROM projects WHERE project_budget=0.00 AND project_terminated=0 ORDER BY project_date DESC LIMIT 100;"; # order by project on desc, limit by sessioned customer
        $statement = $this->database->prepare($projects_sql);
        $result = $statement->execute();
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $projectdto = new projectdto();
            $projectdto->id = $row["project_id"];
            $projectdto->name = $row["project_name"];
            $projectdto->budget = $row["project_budget"];
            $projectdto->paid = $row["project_paid"];
            $projectdto->date = $row["project_date"];
            $projectdto->active = $row["project_active"];
            $projectdto->terminated = $row["project_terminated"];
            
            $projects[] = $projectdto;
        }
        
        return $projects;
    }
    
    public function estimate($project_id="", $project_budget=0.00, $estimated_notes="")
    {
        $estimate_project_sql="UPDATE projects SET project_budget=:project_budget WHERE project_id=:project_id LIMIT 1;";
        $statement = $this->database->prepare($estimate_project_sql);
        $statement->bindParam(":project_id", $project_id, SQLITE3_TEXT);
        $statement->bindParam(":project_budget", $project_budget, SQLITE3_TEXT);        
        $result = $statement->execute();
        
        $estimations_sql="INSERT INTO estimations (estimation_id, project_id, estimated_on, estimated_budget, estimated_notes) VALUES (:estimation_id, :project_id, :estimated_on, :estimated_budget, :estimated_notes);";
        $statement = $this->database->prepare($estimations_sql);
        $estimation_id = (new guid())->NewGuid();
        $estimated_on = date("Y-m-d H:i:s");
        $statement->bindParam(":estimation_id", $estimation_id, SQLITE3_TEXT);
        $statement->bindParam(":project_id", $project_id, SQLITE3_TEXT);
        $statement->bindParam(":estimated_on", $estimated_on, SQLITE3_TEXT);
        $statement->bindParam(":estimated_budget", $project_budget, SQLITE3_TEXT);
        $statement->bindParam(":estimated_notes", $estimated_notes, SQLITE3_TEXT);
        $result = $statement->execute();
        
        return $result;
    }
    
    public function single($project_id=""): projectdto
    {
        # Todo bind the customer id as well
        $single_project_sql="SELECT * FROM projects WHERE project_id=:project_id LIMIT 1;";
        $statement = $this->database->prepare($single_project_sql);
        $statement->bindParam(":project_id", $project_id);
        $result = $statement->execute();

        $projectdto = new projectdto();
        if($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $projectdto->id = $row["project_id"];
            $projectdto->name = $row["project_name"];
            $projectdto->budget = $row["project_budget"];
            $projectdto->paid = $row["project_paid"];
            $projectdto->date = $row["project_date"];
            $projectdto->active = $row["project_active"];
            $projectdto->terminated = $row["project_terminated"];

            $projectdto->customer = $row["customer_id"];
       }
 
        return $projectdto;
    }
    
    public function terminate(projectdto $projectdto, $reason=0): bool
    {
        $update_project_sql="UPDATE projects SET project_terminated=:project_terminated, project_active=0 WHERE project_id=:project_id;";
        $statement = $this->database->prepare($update_project_sql);
        $statement->bindParam(":project_id", $projectdto->id, SQLITE3_TEXT);
        $statement->bindParam(":project_terminated", $reason, SQLITE3_TEXT);
        $result = $statement->execute();
        
        $terminationdto = new terminationdto();
        $terminationdto->id = (new guid())->NewGuid();
        $terminationdto->project = $projectdto->id;
        $terminationdto->reason = $reason;
        $terminationdto->date = date("Y-m-d H:i:s");
        $terminationdto->by = "PHPUnit/Web"; # @todo Logged in User ID here
        
        $termination_log_sql="
INSERT INTO terminations (
    termination_id, project_id, termination_reason, termination_date, termination_by
) VALUES (
    :termination_id, :project_id, :termination_reason, :termination_date, :termination_by
);";
        $statement = $this->database->prepare($termination_log_sql);
        $statement->bindParam(":termination_id", $terminationdto->id, SQLITE3_TEXT);
        $statement->bindParam(":project_id", $projectdto->id, SQLITE3_TEXT);
        $statement->bindParam(":termination_reason", $terminationdto->reason, SQLITE3_INTEGER);
        $statement->bindParam(":termination_date", $terminationdto->date, SQLITE3_TEXT);
        $statement->bindParam(":termination_by", $terminationdto->by, SQLITE3_TEXT);
        $result = $statement->execute();
        
        return $result!=false;
    }
    
    public function artworks($project_id="")
    {
        $artworks_sql="SELECT * FROM artworks WHERE project_id=:project_id;";
        
        $statement = $this->database->prepare($artworks_sql);
        $statement->bindParam(":project_id", $project_id, SQLITE3_TEXT);
        $result = $statement->execute();
        
        $files = [];
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            $file = new filedto();
            $file->id = $row["artwork_id"];
            $file->project = $row["project_id"];
            $file->name = $row["artwork_name"];
            $file->type = $row["artwork_type"];
            $file->error = $row["artwork_error"];
            $file->size = $row["artwork_size"];
            $file->path = $row["artwork_path"];
            $file->active = $row["artwork_active"];
            $file->date = $row["artwork_date"];
            
            $files[] = $file;
       }
       
       return $files;
    }
    
    public function estimation_history($project_id="")
    {
        $estimations_history_sql="SELECT * FROM estimations WHERE project_id=:project_id ORDER BY estimated_on DESC;";
        
        $statement = $this->database->prepare($estimations_history_sql);
        $statement->bindParam(":project_id", $project_id, SQLITE3_TEXT);
        $result = $statement->execute();
        
        $estimation_history = [];
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            $estimationdto = new estimationdto();
            $estimationdto->id = $row["estimation_id"];
            $estimationdto->date = $row["estimated_on"];            
            $estimationdto->budget = $row["estimated_budget"];            
            $estimationdto->notes = $row["estimated_notes"];            
            
            $estimation_history[] = $estimationdto;
       }
       
       return $estimation_history;
    }
    
    public function payment_history($project_id="")
    {
        $payment_history_sql="SELECT * FROM payments WHERE project_id=:project_id ORDER BY payment_on DESC;";
        
        $statement = $this->database->prepare($payment_history_sql);
        $statement->bindParam(":project_id", $project_id, SQLITE3_TEXT);
        $result = $statement->execute();
        
        $payment_history = [];
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            #print_r($row);
            $paymentdto = new paymentdto();
            $paymentdto->id = $row["payment_id"];
            $paymentdto->project = $row["project_id"];            
            $paymentdto->amount = $row["payment_amount"];            
            $paymentdto->reference = $row["payment_reference"];            
            $paymentdto->date = $row["payment_on"];            
            $paymentdto->from = $row["payment_from"]; # @todo Payment from           
            
            $payment_history[] = $paymentdto;
       }
       
       return $payment_history;
    }
    
    public function maintenance()
    {
    }
}
