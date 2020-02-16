<?php
namespace tests;

use dtos\projectdto;
use slicing\project;
use PHPUnit\Framework\TestCase;

class terminationTest extends TestCase
{
    public function testProjectTermination()
    {
        $projectdto = new projectdto();
        $projectdto->id = "545AF421-B192-EA82-6F88-0EB61D5F3AF4";
        #$projectdto->customer = null;
        $projectdto->name = null;
        $projectdto->date = null;
        $projectdto->budget = null;
        $projectdto->paid = null;
        $projectdto->active = null;
        $projectdto->terminated = null;

        $project = new project();
        $terminated = $project->terminate($projectdto);

        $this->AssertTrue($terminated);
    }
}