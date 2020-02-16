<?php
namespace admin;

use slicing\email;

require_once "../inc.config.php";

$mailer = new email();
// $mailer->deliver();

header("Location: projects-recent.php");
