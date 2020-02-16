<?php
namespace admin;

require_once "../inc.config.php";

use dtos\userdto;
use slicing\developer;

$developer = new developer();
$developers = $developer->recent();
#print_r($developers);

$smarty->assign("developers", $developers);
$smarty->display("developers.html");
