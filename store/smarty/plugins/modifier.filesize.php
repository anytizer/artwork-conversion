<?php
# https://stackoverflow.com/questions/8185828/smarty-modifier-filesize/8187127

function smarty_modifier_filesize($size=0)
{
    $size = max(0, (int)$size);
    $units = array( "b", "Kb", "Mb", "Gb", "Tb", "Pb", "Eb", "Zb", "Yb");
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, ".", ",") ." ". $units[$power];
}
