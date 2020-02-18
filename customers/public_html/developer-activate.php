<?php
namespace customers;

use \slicing\developer;

require_once "../inc.config.php";

$id = id($_GET["id"]);
$code = id($_GET["code"]);

$developer = new developer();
if($developer->activate($id, $code))
{
    $_SESSION["customer"] = $id;
    header("Location: profile.php");
}
else
{
    echo "Error!";
}