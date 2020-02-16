<?php
namespace admin;

require_once "../inc.config.php";

$_SESSION["admin"] = null;
header("Location: index.php");
