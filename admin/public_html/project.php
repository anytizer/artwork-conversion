<?php
namespace admin;

require_once "../inc.config.php";

use \dtos\projectdto;
use \slicing\project;

if(empty($_GET["id"]))
{
    die("Invalid Project ID.");
}

$project_id = $_GET["id"];

$project = (new project())->single($project_id);
#print_r($project);

# List of artwrok attached to a project
$artworks = (new project())->artworks($project_id);
#print_r($artworks);

# List of estimation histories
$estimation_history = (new project())->estimation_history($project_id);
#print_r($estimation_history);

$payment_history = (new project())->payment_history($project_id);
#print_r($payment_history);

$smarty->assign("project", $project);
$smarty->assign("artworks", $artworks);
$smarty->assign("estimation_history", $estimation_history);
$smarty->assign("payment_history", $payment_history);
$smarty->display("project.html");
