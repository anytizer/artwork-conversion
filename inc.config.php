<?php
/**
 * @return string Random Password
 */
function password_plain()
{
    # alpha
    # numeric
    # multi cased
    # symbols
    # difficult

    # Scrambled combinations
    $uppercase = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
    $lowercase = str_shuffle("abcdefghijklmnopqrstuvwxyz");
    $numeric = str_shuffle("0123456789");
    $symbols = str_shuffle("@#\$%{}[];");

    $plain = "";
    $plain .= substr($uppercase, 0, mt_rand(3, 5));
    $plain .= substr($symbols, 0, mt_rand(3, 5));
    $plain .= substr($lowercase, 0, mt_rand(3, 5));
    $plain .= substr($numeric, 0, mt_rand(3, 5));
    return $plain;
}

/**
 * @param string $something
 * @return false|string|null
 */
function password($something="")
{
    $hash = password_hash($something, PASSWORD_DEFAULT);
    return $hash;
}

/**
 * @param string $id
 * @return string|string[]|null
 */
function id($id="")
{
    $guid = preg_replace("/[^A-F0-9\-]/s", "", $id);
    if(strlen($guid)!=36)
    {
        trigger_error("Invalid ID format.");
    }
    
    return $guid;
}

/**
 * Common file for admin, customers and developers, cron and hooks.
 */
require_once "vendor/autoload.php";

define("__LIVE__", false);
define("__ROOT__", __DIR__);

ignore_user_abort(true);
set_time_limit(0);
error_reporting(E_ALL|E_STRICT);
ini_set("memory_limit", "16M");
ini_set("log_errors", __ROOT__."/store/errors/errors.log");
ini_set("session.save_path", __ROOT__."/store/sessions");
date_default_timezone_set("America/Edmonton");
session_start();

use anytizer\includer;
spl_autoload_register(array(new includer(__ROOT__."/store/classes"), "namespaced_inc_dot"));

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

# Global variables
use \slicing\configs;
$configs = new configs();
$company = $configs->section("company");
$websites = $configs->section("websites");
$finance = $configs->section("finance");
$config = $configs->section("config");

$smarty->assign("company", $company);
$smarty->assign("websites", $websites);
$smarty->assign("finance", $finance);
$smarty->assign("config", $config);
$smarty->assign("current_year", date("Y"));
