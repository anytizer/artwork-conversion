<?php
namespace customers;

require_once "../inc.config.php";

use dtos\projectdto;
use slicing\project;

$project = new project();
$projects = $project->dues($_SESSION["customer"]);
#print_r($projects);

$smarty->assign("projects", $projects);
$smarty->display("projects-dues.html");
