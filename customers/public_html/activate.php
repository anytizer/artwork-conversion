<?php
namespace customers;

require_once "../inc.config.php";

use \slicing\customer;

$id = id($_GET["id"]);
$code = $_GET["code"];

$customer = new customer();
$customerdto = $customer->single($id);

if($customerdto->id)
{
    if($activated = $customer->activate($customerdto->id, $code))
    {
        $_SESSION["customer"] = $customerdto->id;
        $_SESSION["name"] = $customerdto->name;
    }
}

header("Location: profile.php");
