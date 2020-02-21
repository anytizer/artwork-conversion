<?php
namespace phpunit;

use \slicing\configs;
use PHPUnit\Framework\TestCase;

class configTest extends TestCase
{
    public function testSmtpConfiguration()
    {
        $configs = new configs();
        $smtp = $configs->section("smtp");
        
        $this->assertArrayHasKey("hostname", $smtp);
        $this->assertArrayHasKey("username", $smtp);
        $this->assertArrayHasKey("password", $smtp);
        $this->assertArrayHasKey("encryption", $smtp);
        $this->assertArrayHasKey("port", $smtp);
        $this->assertArrayHasKey("from", $smtp);
        $this->assertArrayHasKey("name", $smtp);
    }
    
    public function testCompanyConfiguration()
    {
        $configs = new configs();
        $company = $configs->section("company");
        
        $this->assertArrayHasKey("name", $company);
        $this->assertArrayHasKey("title", $company);
        $this->assertArrayHasKey("description", $company);
        $this->assertArrayHasKey("phone", $company);
        $this->assertArrayHasKey("email", $company);
        $this->assertArrayHasKey("website", $company);
        $this->assertArrayHasKey("address", $company);
        $this->assertArrayHasKey("registration", $company);
    }

    public function testWebsitesConfiguration()
    {
        $configs = new configs();
        $websites = $configs->section("websites");

        $this->assertArrayHasKey("api", $websites);
        $this->assertArrayHasKey("admin", $websites);
        $this->assertArrayHasKey("assets", $websites);
        $this->assertArrayHasKey("customer", $websites);
        $this->assertArrayHasKey("developer", $websites);
        $this->assertArrayHasKey("hooks", $websites);
        $this->assertArrayHasKey("www", $websites);
    }

    public function testFinanceConfiguration()
    {
        $configs = new configs();
        $finance = $configs->section("finance");

        $this->assertArrayHasKey("paypal", $finance);
    }

    public function testArbitraryConfiguration()
    {
        $configs = new configs();
        $config = $configs->section("config");

        $this->assertArrayHasKey("key", $config);
    }
}
