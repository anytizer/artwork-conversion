<?php
namespace admin;

use \slicing\customer;

require_once "../inc.config.php";

$customer = new customer();
$customers = $customer->get_all_active_customers();
#print_r($customers);

$smarty->assign("customers", $customers);
$smarty->display("customers.html");
