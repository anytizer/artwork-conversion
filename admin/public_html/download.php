<?php
namespace admin;

require_once "../inc.config.php";

use \dtos\filedto;
use \slicing\filedownloader;

$artwork_id = id($_GET["id"]);

$path = __ROOT__."/store/concepts/{$artwork_id}.upload";
if(file_exists($path))
{
    # File uploader
    $fd = new filedownloader();
    $details = $fd->single($artwork_id);

    // get the db details
    // set header
    // read the file
    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"{$details->name}\"");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: {$details->size}");
    
    readfile($path);
}
else
{
    echo "Invalid file: {$artwork_id}";
}
