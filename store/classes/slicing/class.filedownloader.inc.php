<?php
namespace slicing;

use \dtos\filedto;

class filedownloader
{
    public function details($file=""): filedto
    {
        $filedto = new filedto();
        
        $file = id($file);
        return $filedto;
    }
}
