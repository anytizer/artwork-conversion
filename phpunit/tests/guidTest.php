<?php
namespace tests;

use anytizer\guid;
use PHPUnit\Framework\TestCase;

class guidTest extends TestCase
{
    private $guid;

    public function setup(): void
    {
        $this->guid = (new guid())->NewGuid();
    }

    public function testGuidIdFormat()
    {
        $new = preg_replace("/[^0-9A-F\-]/s", "", $this->guid);

        $this->AssertEquals($this->guid, $new);
    }
}
