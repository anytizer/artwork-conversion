<?php
namespace customers;

require_once "../inc.config.php";

use \dtos\projectdto;
use \slicing\project;
use \slicing\fileuploader;

$artworks = [];
$fname = "concepts";
if(!empty($_FILES[$fname]))
{
    $fu = new fileuploader();
    $artworks = $fu->upload($fname, $concepts_artwork_path);
}
else
{
    #print_r($_FILES[$fname]);
    die("Artwork not uploaded...");
}

$projectdto = new projectdto();
$projectdto->id = id($_POST["project"]);
#$projectdto->customer = $customerdto->id;
$projectdto->name =  null;;
$projectdto->date = null;
$projectdto->budget = null;
$projectdto->paid = null;
$projectdto->active = null;

$project = new project();
$project->attach_artwork($projectdto, $artworks);

# @todo Send an email to the admin

header("Location: project.php?id={$projectdto->id}");
#header("Location: projects-recent.php");
