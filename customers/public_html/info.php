<?php
namespace customers;

require_once "../inc.config.php";

header("Content-Type: text/plain");
print_r($_SESSION);

#$smarty->display("session", $_SESSION);
#$smarty->display("info.html");
