<?php
namespace admin;

require_once "../inc.config.php";

use \dtos\projectdto;
use \slicing\email;
use \slicing\project;

$project_id = id($_POST["project_id"]);

$project = new project();
#print_r($_POST); die();

// ask payment
$estimation = $project->estimate($project_id, $_POST["budget"], $_POST["notes"]);

$email = new email();
$email->ask_payment($project_id);
/**
Array
(
    [budget] => 11
    [notes] => 1123456
    [project_id] => EEA6C9BE-1F69-E7C7-E330-CE8092D0FFEA
    [askpayment] => Ask Payment
)
*/

header("Location: project.php?id={$project_id}");
#header("Location: projects-estimations.php");
