<?php
namespace admin;

require_once "../inc.config.php";

use dtos\paymentdto;
use slicing\payment;

$payment = new payment();
$payments = $payment->recent_admin();
#print_r($payments);

$smarty->assign("payments", $payments);
$smarty->display("payments.html");
