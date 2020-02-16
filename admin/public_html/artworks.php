<?php
namespace admin;

require_once "../inc.config.php";

use \slicing\fileuploader;

$fu = new fileuploader();
$artworks = $fu->artworks();
#print_r($artworks);

$smarty->assign("artworks", $artworks);
$smarty->display("artworks.html");
