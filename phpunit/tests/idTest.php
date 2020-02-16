<?php
namespace tests;

use dtos\workdto;
use slicing\work;
use anytizer\guid;
use PHPUnit\Framework\TestCase;

class idTest extends TestCase
{
    public function testIdReplacement()
    {
        $id = "84724FAC-80E2-4B12-B061-751EF37E43A2Z";
        $id = id($id);

        $expect = "84724FAC-80E2-4B12-B061-751EF37E43A2";

        $this->assertEquals($expect, $id);
        $this->assertEquals(36, strlen($id));
    }
}
