<?php
namespace admin;

require_once "../inc.config.php";

use \dtos\userdto;
use \slicing\developer;
use \slicing\email;

$id = id($_GET["id"]);
$developer = new developer();
$userdto = $developer->single($id);

$developer_onboarded = $developer->onboarded($userdto);

if($userdto->onboarded == "0")
{
    $email = new email();
    $developer_informed = $email->developer_onboarded($userdto->id);
}

header("Location: developers.php");
