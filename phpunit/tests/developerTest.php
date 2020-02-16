<?php
namespace tests;

use dtos\userdto;
use slicing\developer;
use demo\provider;
use anytizer\guid;
use PHPUnit\Framework\TestCase;

class developerTest extends TestCase
{
    public function setup(): void
    {
        // delete all developers
        // $developer = new developer();
        // $developer->clear();
    }
    
    public function testCreateDeveloper()
    {
        $provider = new provider();
        $password_plain = password_plain();
        
        $userdto = new userdto();
        $userdto->id = (new guid())->NewGuid();
        $userdto->name = $provider->name();
        $userdto->email = "{$userdto->id}@example.com";
        $userdto->password = password($password_plain);
        $userdto->code = $provider->code();
        $userdto->active = "0";
        
        $userdto->onboarded = "0";

        $developer = new developer();
        $developer_created = $developer->create($userdto);

        $this->AssertTrue($developer_created);
    }
}
