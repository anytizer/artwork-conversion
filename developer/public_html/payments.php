<?php
namespace developer;

require_once "../inc.config.php";

use \dtos\paymentdto;
use \slicing\payment;

$payment = new payment();
$payments = $payment->recent();
#print_r($payments);

$smarty->assign("payments", $payments);
$smarty->display("payments.html");
