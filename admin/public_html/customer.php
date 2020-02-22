<?php
namespace admin;

use \slicing\customer;
use slicing\project;

require_once "../inc.config.php";

$customer_id = id($_GET["id"]);

$customer = new customer();

$customerdto = $customer->single($customer_id);
$statistics = $customer->statistics($customerdto);
#print_r($statistics);

$project = new project();
$projects = $project->recent($customerdto->id);
#print_r($projects);

$smarty->assign("customer", $customerdto);
$smarty->assign("statistics", $statistics);
$smarty->assign("projects", $projects);
$smarty->display("customer.html");
