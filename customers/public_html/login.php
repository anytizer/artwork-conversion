<?php
namespace customers;

require_once "../inc.config.php";

use \slicing\customer;
use \dtos\customerdto;
use \dtos\logindto;

$_SESSION["customer"] = null;
$_SESSION["name"] = null;

if(isset($_POST["login"]))
{
    $attempt = new logindto();
    $attempt->email = $_POST["email"];
    $attempt->password = $_POST["password"];

    $customer = new customer();
    if($customer->login($attempt))
    {
        #die("Password matched");
        $customerdto = $customer->details_by_email($attempt->email);
        #print_r($customerdto);
        #die();
        $_SESSION["customer"] = $customerdto->id;
        $_SESSION["name"] = $customerdto->name;

        header("Location: {$websites['customer']}/dashboard.php");
        die();
    }
    else
    {
        die("Login failed.");
    }
}

$smarty->display("login.html");
