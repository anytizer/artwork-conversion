<?php
namespace admin;

require_once "../inc.config.php";

use \dtos\projectdto;
use slicing\email;
use \slicing\project;

#$_GET["id"]="88C0A147-6DB6-A776-4236-35C2DB700D1A";
#$_GET["reason"]="2";

if(empty($_GET["id"]))
{
    die("Invalid Project ID.");
}

$project_id = id($_GET["id"]);
$reason = $_GET["reason"];

$project = new project();
$projectdto = $project->single($project_id);
$project->terminate($projectdto, $reason);

$email = new email();
$informed = $email->terminate_project($project_id);

#print_r($projectdto);
#die("Terminated!");
header("Location: projects-recent.php");
