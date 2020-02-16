<?php
namespace customers;

require_once "../inc.config.php";

unset($_SESSION["customer"]);

header("Location: index.php");
