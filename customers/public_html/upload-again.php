<?php
namespace customers;

require_once "../inc.config.php";

use \dtos\projectdto;
use \dtos\userdto;
use \slicing\email;
use \slicing\project;
use \slicing\fileuploader;
use anytizer\guid;

$artworks = [];
$fname = "concepts";
if(!empty($_FILES[$fname]["name"][0]))
{
    $fu = new fileuploader();
    $artworks = $fu->upload($fname, $concepts_artwork_path);
}
else
{
    #print_r($_FILES[$fname]);
    die("Artwork not uploaded Or, too big file.");
}

$projectdto = new projectdto();
$projectdto->id = (new Guid())->NewGuid();
#$projectdto->customer = $customerdto->id;
$projectdto->name = $_FILES[$fname]["name"][0]." - ".mt_rand(1000, 9999);
$projectdto->date = date("Y-m-d H:i:s");
$projectdto->budget = "0.00";
$projectdto->paid = "0.00";
$projectdto->active = "1";
$projectdto->terminated = "0";

$project = new project();
$userdto = new userdto();
$userdto->id = id($_SESSION["customer"]);
$project_created = $project->create($userdto, $projectdto);
$project->attach_artwork($projectdto, $artworks);

# @todo Send an email to the admin
$email = new email();
$email->upload_again($projectdto->id);

header("Location: project.php?id={$projectdto->id}");
#header("Location: projects-recent.php");
