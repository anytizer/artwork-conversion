<?php
namespace tests;

use demo\provider;
use \dtos\userdto;
use \slicing\admin;
use PHPUnit\Framework\TestCase;

class adminTest extends TestCase
{
    public function setup(): void
    {
    }
    
    public function testCreateAdmin()
    {
        $provider = new provider();
        $password_plain = password_plain();
        $code = md5(password_plain());
        
        $userdto = new userdto();
        $userdto->id = $provider->id();
        $userdto->name = $provider->name();
        $userdto->email = $provider->email();
        $userdto->password = password($password_plain);
        $userdto->code = $code;
        $userdto->active = "0";
        
        $userdto->onboarded = "0"; // optional for admin

        $admin = new admin();
        $admin_created = $admin->create($userdto);

        $this->AssertTrue($admin_created);
    }
    
    // get, single: admin
    // list admins
    // change password
    // login
}
