<?php
require_once "/var/www/html/slicing/inc.config.php";

$_SESSION["admin"] = "";

# Override the configuration
$smarty->setTemplateDir(__ROOT__."/admin/templates");
