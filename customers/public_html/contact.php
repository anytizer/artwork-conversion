<?php
namespace customers;

require_once "../inc.config.php";

use \slicing\info;

#$contacts = (new info())->get();
$contacts = (new info())->getall();
#print_r($contacts);

$smarty->assign("contacts", $contacts);
$smarty->display("contact.html");