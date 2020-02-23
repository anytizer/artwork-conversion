<?php
namespace admin;

require_once "../inc.config.php";

use \slicing\maintenance;

$maintenance = new maintenance();
$results = $maintenance->maintain();

$smarty->assign("results", $results);
$smarty->display("maintenance.html");
