<?php
namespace customers;

require_once "../inc.config.php";

use \slicing\customer;
use \dtos\logindto;

$_POST["password"]["old"] = trim($_POST["password"]["old"]??"");
$_POST["password"]["new"] = trim($_POST["password"]["new"]??"");
if(strlen($_POST["password"]["new"]) <= 4 )
{
    die("Choose a strong password");
}

if($_POST["password"]["new"] != $_POST["password"]["confirm"])
{
    die("Confirm password");
}

if($_POST["password"]["old"] == $_POST["password"]["new"])
{
    die("Cannot reset to same password.");
}

$logindto = new logindto();
$logindto->id = $_SESSION["customer"];
$logindto->password = $_POST["password"]["new"];



#print_r($logindto);
#print_r($_POST);
#die();

/*


dtos\logindto Object
(
    [id] => C0CFD94D-CDE7-7243-757B-C82411AD0473
    [email] => 
    [password] => password370
)
Array
(
    [password] => Array
        (
            [old] => password370
            [new] => password370
            [confirm] => password370
        )

    [change] => Change my Password
)

*/

#header("Location: project.php?id={$projectdto->id}");
#header("Location: projects.php");
