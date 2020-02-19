<?php
namespace customers;

require_once "../inc.config.php";

unset($_SESSION["customer"]);
unset($_SESSION["name"]);

header("Location: index.php");
