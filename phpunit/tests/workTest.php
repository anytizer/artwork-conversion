<?php
namespace tests;

use dtos\workdto;
use slicing\work;
use PHPUnit\Framework\TestCase;

class workTest extends TestCase
{
    public function setup(): void
    {
        // delete all works
        // $work = new work();
        // $work->clear();
    }
    
    public function testCreateNativeIosWork()
    {
        $workdto = new workdto();
        $workdto->id = "81CE381B-6B1D-4970-9027-A744825A5A54";
        $workdto->name = "Native iOS Application";
        $workdto->desc = "Native iOS Application";
        $workdto->active = "1";

        $work = new work();
        $work_created = $work->create($workdto);

        $this->AssertTrue($work_created!=null);
    }
    
    public function testCreateNativeAndroidWork()
    {
        $workdto = new workdto();
        $workdto->id = "EF15BE9A-C137-81E0-7874-5F0E1A344EFE";
        $workdto->name = "Native Android Application";
        $workdto->desc = "Native Android Application";
        $workdto->active = "1";

        $work = new work();
        $work_created = $work->create($workdto);

        $this->AssertTrue($work_created!=null);
    }
    
    public function testCreateDotNetDesktopWork()
    {
        $workdto = new workdto();
        $workdto->id = "A54648D8-3E3D-F59F-4750-49D92458C85C";
        $workdto->name = ".NET Desktop Application";
        $workdto->desc = ".NET Desktop Application";
        $workdto->active = "1";

        $work = new work();
        $work_created = $work->create($workdto);

        $this->AssertTrue($work_created!=null);
    }
    
    public function testCreateWebApplicationWork()
    {
        $workdto = new workdto();
        $workdto->id = "5CF51D24-5F7D-A289-A766-9B83A2186E45";
        $workdto->name = "Web Application";
        $workdto->desc = "Web Application";
        $workdto->active = "1";

        $work = new work();
        $work_created = $work->create($workdto);

        $this->AssertTrue($work_created!=null);
    }
    
    public function testWorksListing()
    {
        $work = new work();
        $works = $work->works();
        $total_works_listed = 4;
        
        $this->assertEquals($total_works_listed, count($works));
    }
}
