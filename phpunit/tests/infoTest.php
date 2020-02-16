<?php
namespace tests;

use \dtos\infodto;
use \slicing\provider;
use \slicing\info;
use \slicing\configs;
use \anytizer\guid;
use PHPUnit\Framework\TestCase;

class infoTest extends TestCase
{
    public function setup(): void
    {
        // MUST delete all info
        //$info = new info();
        //$info->clear();
    }

    public function testCreateInfo1()
    {
        $company = (new configs())->section("company");

        $infodto = new infodto();
        $infodto->id = (new guid())->NewGuid();
        $infodto->company = $company["name"];
        $infodto->phone = $company["phone"];
        $infodto->email = $company["email"];
        $infodto->website = $company["website"];
        $infodto->address = $company["address"];
        $infodto->registration = $company["registration"];
        
        $info = new info();
        $created = $info->create($infodto);
        
        $this->AssertTrue($created);
    }
}
