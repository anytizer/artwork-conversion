<?php
namespace admin;

require_once "../inc.config.php";

use slicing\project;

$project = new project();
$projects = $project->terminated();
#print_r($projects);

$smarty->assign("projects", $projects);
$smarty->display("terminations.html");
