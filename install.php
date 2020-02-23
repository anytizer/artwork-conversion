<?php
use \slicing\info;
use \slicing\work;
use \slicing\maintenance;

require_once "inc.config.php";

$database =__ROOT__."/store/database/slicing.db";

if(!is_file($database))
{
    die("You need a database setup.");
}
else
{
    #die("Database seems to be setup. Make sure that all tables have data.");
}

$maintenance = new maintenance();
$results = $maintenance->maintain();

$info = new info();
$info->clear();

$work = new work();
$work->clear();

echo "Run PHPUnit once.";
