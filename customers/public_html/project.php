<?php
namespace customers;

require_once "../inc.config.php";

use \dtos\projectdto;
use \slicing\project;

#$_GET["id"] = "65A510FF-9423-3A73-BAB4-2883B0109830"; # @todo Remove this line
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

# @todo Get payment history of a project
$payment_history = (new project())->payment_history($project_id);

$smarty->assign("project", $project);
$smarty->assign("artworks", $artworks);
$smarty->assign("payment_history", $payment_history);
$smarty->display("project.html");
