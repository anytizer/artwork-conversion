<?php
namespace customers;

require_once "../inc.config.php";

use \dtos\customerdto;
use \slicing\customer;

$customer = new customer();
$customerdto = $customer->single($_SESSION["customer"]);

#print_r($_SESSION);
#print_r($customerdto);

/*
Array
(
    [login] => Array
        (
            [id] => C0CFD94D-CDE7-7243-757B-C82411AD0473
            [message] => Logged in successfully
        )

)
dtos\customerdto Object
(
    [id] => C0CFD94D-CDE7-7243-757B-C82411AD0473
    [name] => John Chad
    [email] => C0CFD94D-CDE7-7243-757B-C82411AD0473@example.com
    [password] => $2y$10$ZuDlE.SR3aUHxLUhAWQKbezOJ6o851TuLwQfRSBo0pTGvTObKa6r6
    [code] => 58d2460559067378d16e59c1256b56fe
    [active] => 1
)
*/

$smarty->assign("customer", $customerdto);
$smarty->display("profile.html");