<?php
require_once "/var/www/html/slicing/inc.config.php";

$filename = basename($_SERVER["SCRIPT_FILENAME"]);

$freepages = [
    "login.php",
    "index.php",
    "upload.php",
    "join.php",
    "tnc.php",
    "privacy.php",
    "contact.php",
    "about.php",
    "thankyou.php",

    "developer-activate.php",
];

if(!in_array($filename, $freepages))
{
    // protect pages
    if(empty($_SESSION["customer"]))
    {
        header("Location: login.php");
        die("You have not logged in.");
    }

    #die("Non login page needs a protection.");
}

# Override the configuration
$smarty->setTemplateDir(__ROOT__."/customers/templates");
