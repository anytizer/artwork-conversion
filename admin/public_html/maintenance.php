<?php
namespace admin;

require_once "../inc.config.php";

use \slicing\maintenance;

$maintenace = new maintenance();
$results = $maintenace->maintain();

$smarty->assign("results", $results);
$smarty->display("maintenance.html");
