<?php
namespace admin;

use \slicing\customer;

require_once "../inc.config.php";

$customer_id = id($_GET["id"]);

$customer = new customer();
$customer = $customer->single($customer_id);
print_r($customer);

#$smarty->assign("customer", $customer);
#$smarty->display("customer.html");
