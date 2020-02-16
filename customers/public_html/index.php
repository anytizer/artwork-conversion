<?php
namespace customers;

require_once "../inc.config.php";

use \slicing\stats;

$statistics = (new stats())->all_statistics();
#print_r($statistics);

$smarty->assign("statistics", $statistics);
$smarty->display("index.html");
