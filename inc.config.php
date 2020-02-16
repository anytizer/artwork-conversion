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

    /**
     * @todo Make password harder
     */
    $plain = "password"; // .mt_rand(100, 999);
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

define("__ROOT__", dirname(__FILE__));

ignore_user_abort(true);
set_time_limit(0);

ini_set("session.save_path", __ROOT__."/store/sessions");
session_start();

use anytizer\includer;
spl_autoload_register(array(new includer(__ROOT__."/store/classes"), "namespaced_inc_dot"));

use slicing\configs;
$configs = new configs();
$company = $configs->section("company");

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
$smarty->assign("company_name", $company["name"]);
$smarty->assign("company_title", $company["title"]);
$smarty->assign("company_description", $company["description"]);
$smarty->assign("current_year", date("Y"));

error_reporting(E_ALL|E_STRICT);