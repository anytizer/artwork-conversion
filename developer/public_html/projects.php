<?php
namespace developer;

require_once "../inc.config.php";

use \dtos\projectdto;
use \slicing\project;

$project = new project();
$projects = $project->recent();
#print_r($projects);

$smarty->assign("projects", $projects);
$smarty->display("projects.html");
