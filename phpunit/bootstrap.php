<?php
use slicing\work;
use slicing\info;

require_once "../inc.config.php";

# Only for test purposes, run once automatically.
# Not sufficient by setup()
$work = new work();
$work->clear();

$info = new info();
$info->clear();
