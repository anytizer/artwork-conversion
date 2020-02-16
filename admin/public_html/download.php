<?php
namespace admin;

require_once "../inc.config.php";

use \slicing\filedownloader;

$file = id($_GET["file"]);

$path = __ROOT__."/store/concepts/{$file}.upload";
if(file_exists($path))
{
    # File uploader
    $fd = new filedownloader();
    $details = $fd->details($_GET["file"]);
    
    // get the db details
    // set header
    // read the file
    $name = basename($file);
    $size = filesize($path);
    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"{$name}\"");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: {$size}");
    
    readfile($path);
}
else
{
    echo "Invalid file: {$file}";
}
