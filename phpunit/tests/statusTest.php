<?php
namespace tests;

use demo\provider;
use \dtos\idnamedto;
use \slicing\status;
use PHPUnit\Framework\TestCase;

class statusTest extends TestCase
{
    public function setup(): void
    {
        $status = new status();
        $status->clear();
    }
    
    public function testCreateStatus()
    {
        $provider = new provider();
        $statuses = $provider->statuses();

        foreach($statuses as $s => $status_name)
        {
            $idnamedto = new idnamedto();
            $idnamedto->id = $provider->id();
            $idnamedto->name = $status_name;

            $status = new status();
            $status_created = $status->create($idnamedto);

            $this->AssertTrue($status_created, "Failed creating a status.");
        }
    }
}
