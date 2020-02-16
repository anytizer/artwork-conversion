<?php
namespace admin;

require_once "../inc.config.php";

use dtos\userdto;
use slicing\developer;

$userdto = new userdto();
$userdto->id = id($_GET["id"]);
$userdto->name = null;
$userdto->email = null;
$userdto->password = null;
$userdto->active = null;
$userdto->onboarded = null;

$developer = new developer();
$developer_created = $developer->flag($userdto);
#$developer_emailed = $developer->invite($userdto);

header("Location: developers.php");
