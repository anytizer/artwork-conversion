<?php
namespace tests;

use demo\provider;
use \dtos\userdto;
use \dtos\projectdto;
use \slicing\project;
use \slicing\hook;
use PHPUnit\Framework\TestCase;

class projectTest extends TestCase
{
    // known ids
    private $project_id;
    private $customer_id;
    
    public function setup(): void
    {
        # SELECT project_id FROM projects LIMIT 1;
        # WHERE there is an attachment
        $this->project_id = "39279BB7-B89C-BA4D-9D1E-1A62F3EA7238";
        $this->customer_id = "21B70F6B-8E3A-773A-F4F3-E042C0A71B2A";
    }
    
    public function testCreateProject()
    {
        $provider = new provider();

        $userdto = new userdto();
        $userdto->id = $provider->id();
        $userdto->name = "Customer Name";
        $userdto->email = "john.doe@example.com";
        $userdto->password = password_plain();
        $userdto->code = md5(password_plain());
        $userdto->active = "1";
        
        $projectdto = new projectdto();
        $projectdto->id = $provider->id();
        #$projectdto->customer = $userdto->id;
        $projectdto->name = "My Project - ".mt_rand(1000, 9999);
        $projectdto->date = date("Y-m-d H:i:s");
        $projectdto->budget = "0.00"; // must be estimated later
        $projectdto->paid = "0.00";
        $projectdto->active = "1";
        $projectdto->terminated = "0";
        
        $project = new project();
        $project_created = $project->create($userdto, $projectdto);

        $this->AssertTrue($project_created!=null);
    }
    
    public function testSingleProjectDetailsExists()
    {
        $project = new project();
        $single = $project->single($this->project_id);
        
        $this->assertTrue(""!=$single->id);
    }
    
    public function testProjectArtworksExist()
    {
        $project = new project();
        $artwroks = $project->artworks($this->project_id);
        
        $this->assertTrue(count($artwroks)>=1);
    }
    
    public function testEstimateProject()
    {
        $project = new project();
        $estimation = $project->estimate($this->project_id, 90.00);
        
        $this->assertTrue($estimation != null);
    }
    
    public function testHookProjectPaid()
    {
        $budget = mt_rand(10, 999);
        $reference = "REF PHPUnit - ".mt_rand(100, 999);
        
        $hook = new hook();
        $marked = $hook->mark_project_paid($this->project_id, $budget, $reference);

        $this->assertTrue($marked);
    }
    
    // @todo Recent projects is bound to customer ID.
    public function testRecentProjectsBoundToCustomerId()
    {
        $project = new project();
        $projects = $project->recent($this->customer_id);
        
        $total = 1;
        $this->assertEquals($total, count($projects));
    }
}
