<?php
require_once "/var/www/html/slicing/inc.config.php";

$_SESSION["developer"] = "";

# Override the configuration
$smarty->setTemplateDir(__ROOT__."/developer/templates");
