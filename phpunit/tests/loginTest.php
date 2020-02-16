<?php
namespace tests;

use dtos\customerdto;
use dtos\logindto;
use slicing\customer;
use demo\provider;
use PHPUnit\Framework\TestCase;

class loginTest extends TestCase
{
    public function testCustomerLogin()
    {
        $password_plain = password_plain();
        
        $provider = new provider();
        $customerdto = $provider->get_unregistered_customer();
        $customerdto->password = password($password_plain); // reset to a known password
        
        $customer = new customer();
        $customer_created = $customer->create($customerdto);
        $customer_activated = $customer->activate($customerdto->email, $customerdto->code);
        
        $attempt = new logindto();
        $attempt->email = $customerdto->email;
        $attempt->password = $password_plain;

        $customer_login = $customer->login($attempt);
        
        $this->assertTrue($customer_created, "Customer not created for login.");
        $this->assertTrue($customer_login, "Customer login failed.");
    }
    
    public function testCustomerChangePassword()
    {
        $customer = new customer();
        #$customer->password_change();
        # Cannot login with old user account
        # Can login with new account
        $this->markTestIncomplete();
    }
}
