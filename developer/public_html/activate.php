<?php
namespace developer;

use \slicing\developer;

require_once "../inc.config.php";

$id = id($_GET["id"]);
$code = $_GET["code"];

$developer = new developer();
$developerdto = $developer->single($id);
if($developer->activate($id, $code))
{
    $_SESSION["developer"] = $developerdto->id;
    header("Location: profile.php");
}
else
{
    echo "Error!";
}
