<?php
namespace admin;

require_once "../inc.config.php";

use demo\provider;
use \dtos\userdto;
use \slicing\developer;
use anytizer\guid;

$provider = new provider();
$password_plain = password_plain();

$userdto = new userdto();
$userdto->id = $provider->id();
$userdto->name = $_POST["developer"]["name"];
$userdto->email = $_POST["developer"]["email"];
$userdto->password = password($password_plain);
$userdto->code = md5(password_plain()); // user needs to activate
$userdto->active = "0"; // user needs to activate
$userdto->onboarded = "1"; // pre-onboarded

$developer = new developer();
$developer_created = $developer->create($userdto);
#$developer_emailed = $developer->invite($userdto);

header("Location: developers.php");
