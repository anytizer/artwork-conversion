<?php
namespace customers;

require_once "../inc.config.php";

use \slicing\maintenance;

$maintenance = new maintenance();
$maintenance->borrow($_SESSION["customer"]);

header("Location: projects.php");
