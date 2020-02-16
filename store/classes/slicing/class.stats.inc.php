<?php
namespace slicing;

use dtos\statsdto;
use slicing\database;

class stats extends database
{
    private $statistics = [];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function all_statistics()
    {
        $this->statistics["developers"] = $this->developers();
        $this->statistics["customers"] = $this->customers();
        $this->statistics["projects"] = $this->projects();
        $this->statistics["queue"] = $this->queue();
        $this->statistics["delivery"] = $this->delivery();
        $this->statistics["works"] = $this->works();
        
        return $this->statistics;
    }
    
    private function developers()
    {
        $name = "Total Developers";
        $value = 5;
        $icon = "developers.png";
        $link = "#";

        # How many active onboarded developers are there?
        $counter_sql="SELECT COUNT(*) total FROM developers WHERE developer_active=1 AND developer_onboarded=1;";
        $statement = $this->database->prepare($counter_sql);
        $result = $statement->execute();
        $rows = $result->fetchArray(SQLITE3_ASSOC);
        $value = $rows["total"];

        $stat = new statsdto();
        $stat->name = $name;
        $stat->value = $value;
        $stat->icon = $icon;
        $stat->link = $link;

        return $stat;
    }

    private function customers()
    {
        $name = "Total Customers";
        $value = 5;
        $icon = "customers.png";
        $link = "#";

        $counter_sql="SELECT COUNT(*) total FROM customers WHERE customer_active=1;";
        $statement = $this->database->prepare($counter_sql);
        $result = $statement->execute();
        $rows = $result->fetchArray(SQLITE3_ASSOC);
        $value = $rows["total"];

        $stat = new statsdto();
        $stat->name = $name;
        $stat->value = $value;
        $stat->icon = $icon;
        $stat->link = $link;

        return $stat;
    }

    private function projects()
    {
        $name = "Total Projects";
        $value = 0;
        $icon = "projects.png";
        $link = "#";
        
        # How many active projects are there?
        $counter_sql="SELECT COUNT(*) total FROM projects;";
        $statement = $this->database->prepare($counter_sql);
        $result = $statement->execute();
        $rows = $result->fetchArray(SQLITE3_ASSOC);
        $value = $rows["total"];
        
        $stat = new statsdto();
        $stat->name = $name;
        $stat->value = $value;
        $stat->icon = $icon;
        $stat->link = $link;
        
        return $stat;
    }
    
    private function queue()
    {
        $name = "Your Queue";
        $value = 24;
        $icon = "queue.png";
        $link = "#";
        
        # @todo Unestimated projects counter
        $counter_sql="SELECT COUNT(*) total FROM projects WHERE project_terminated=0;";
        $statement = $this->database->prepare($counter_sql);
        $result = $statement->execute();
        $rows = $result->fetchArray(SQLITE3_ASSOC);
        $value = $rows["total"];
        
        $stat = new statsdto();
        $stat->name = $name;
        $stat->value = $value;
        $stat->icon = $icon;
        $stat->link = $link;
        
        return $stat;
    }
    
    private function delivery()
    {
        $name = "Avg. Delivery Days";
        $value = 4;
        $icon = "delivery.png";
        $link = "#";
        
        $stat = new statsdto();
        $stat->name = $name;
        $stat->value = $value;
        $stat->icon = $icon;
        $stat->link = $link;
        
        return $stat;
    }

    public function works()
    {
        $name = "Work Varieties";
        $value = 4;
        $icon = "work.png";
        $link = "join.php";

        $counter_sql="SELECT COUNT(*) total FROM works;";
        $statement = $this->database->prepare($counter_sql);
        $result = $statement->execute();
        $rows = $result->fetchArray(SQLITE3_ASSOC);
        $value = $rows["total"];
        
        $stat = new statsdto();
        $stat->name = $name;
        $stat->value = $value;
        $stat->icon = $icon;
        $stat->link = $link;
        
        return $stat;
    }
}
