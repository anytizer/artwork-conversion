<?php
namespace customers;

require_once "../inc.config.php";

use \slicing\work;
use \dtos\workdto;

$works = (new work())->works();

$smarty->assign("works", $works);
$smarty->display("join.html");
