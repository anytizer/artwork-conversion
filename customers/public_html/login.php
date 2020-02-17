<?php
namespace customers;

require_once "../inc.config.php";

use \slicing\customer;
use \dtos\customerdto;
use \dtos\logindto;

$_SESSION["customer"] = null;

#print_r($_POST); die();
if(isset($_POST["login"]))
{
    $attempt = new logindto();
    $attempt->email = $_POST["email"];
    $attempt->password = $_POST["password"];

    $customer = new customer();
    if($customer->login($attempt))
    {
        $customerdto = $customer->single($attempt->email);
        $_SESSION["customer"] = $customerdto->id;
        
        header("Location: dashboard.php");
    }
}

$smarty->display("login.html");
