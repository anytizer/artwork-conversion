<?php
namespace admin;

require_once "../inc.config.php";

use slicing\maintenance;

$maintenance = new maintenance();
$maintenance->backup();
$maintenance->reinstall();

$smarty->display("reinstall.html");
