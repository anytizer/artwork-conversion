<?php
namespace customers;

require_once "../inc.config.php";

use dtos\paymentdto;
use slicing\payment;

$payment = new payment();
$payments = $payment->recent($_SESSION["customer"]);
#print_r($payments);

$smarty->assign("payments", $payments);
$smarty->display("payments.html");
