<?php
namespace tests;

use \dtos\customerdto;
use \dtos\logindto;
use \slicing\customer;
use \demo\provider;
use anytizer\guid;
use PHPUnit\Framework\TestCase;

class customerTest extends TestCase
{
    public function testCreateCustomer()
    {
        $provider = new provider();
        $customerdto = $provider->get_unregistered_customer();
        
        $customer = new customer();
        $customer_created = $customer->create($customerdto);

        $this->AssertTrue($customer_created);
    }
    
    public function testCreateMultipleCustomers()
    {
        $provider = new provider();
        
        for($i=0; $i<1; ++$i)
        {
            $customerdto = $provider->get_unregistered_customer();
            
            $customer = new customer();
            $customer_created = $customer->create($customerdto);

            $this->AssertTrue($customer_created);
        }
    }
    
    public function testActivateCustomer()
    {
        $provider = new provider();
        $customerdto = $provider->get_unregistered_customer();
        
        $customer = new customer();
        $customer_created = $customer->create($customerdto);
        
        $activated = $customer->activate($customerdto->id, $customerdto->code);
        // $customer->activate($link_id);
        // simulate email link clicked
        // activate.php?customer=ID&code=CODE
        $this->assertTrue($activated);
    }

    public function testLoginACustomer()
    {
        $this->markTestIncomplete();
    }
}
