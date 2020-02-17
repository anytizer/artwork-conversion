<?php
namespace admin;

require_once "../inc.config.php";

use \dtos\projectdto;
use \slicing\project;

$project = new project();
$estimates = $project->to_estimate();

$smarty->assign("estimates", $estimates);
$smarty->display("estimations.html");
