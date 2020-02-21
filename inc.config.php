<?php
define("__ROOT__", __DIR__);

/**
 * Common file for admin, customers and developers, cron and hooks.
 */
require_once "inc.functions.php";
require_once "vendor/autoload.php";

use anytizer\includer;
spl_autoload_register(array(new includer(__ROOT__."/store/classes"), "namespaced_inc_dot"));

# Global variables
use \slicing\configs;
$configs = new configs();
$company = $configs->section("company");
$websites = $configs->section("websites");
$finance = $configs->section("finance");
$config = $configs->section("config");
define("__LIVE__", $config["live"]==="true");

date_default_timezone_set("America/Edmonton");
error_reporting(E_ALL|E_STRICT);
ignore_user_abort(true);
ini_set("error_log", __ROOT__."/store/errors/errors.log");
ini_set("file_uploads", "On");
ini_set("log_errors", "On");
ini_set("max_execution_time", "60");
ini_set("max_input_time", "30");
ini_set("memory_limit", "16M");
ini_set("post_max_size", "8M");
ini_set("session.save_path", __ROOT__."/store/sessions");
set_time_limit(60);
session_start();

$concepts_artwork_path = __ROOT__."/store/concepts";
$smarty_templates = __ROOT__."/store/smarty/templates";
$smarty_templates_c = __ROOT__."/store/smarty/templates_c";
$smarty_cache = __ROOT__."/store/smarty/cache";
$smarty_configs = __ROOT__."/store/smarty/configs";
$smarty_plugins = __ROOT__."/store/smarty/plugins";

$smarty = new Smarty();
$smarty->setTemplateDir($smarty_templates);
$smarty->setCompileDir($smarty_templates_c);
$smarty->setCacheDir($smarty_cache);
$smarty->setConfigDir($smarty_configs);
$smarty->setPluginsDir(array(
    $smarty_plugins,
    # "vendor/smarty/smarty/libs/plugins",
));

/**
 * Assign all of configs for templates
 */
$smarty->assign("company", $company);
$smarty->assign("websites", $websites);
$smarty->assign("finance", $finance);
$smarty->assign("config", $config);
#$smarty->assign("current_year", date("Y"));
