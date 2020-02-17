<?php
namespace tests;

use \slicing\stats;
use PHPUnit\Framework\TestCase;

class statisticsTest extends TestCase
{
    public function testStatisticsCounter()
    {
        $stats = new stats();
        $all = $stats->all_statistics();

        # How many statistics are available?
        $total = 6;

        $this->assertEquals($total, count($all));
    }
}
