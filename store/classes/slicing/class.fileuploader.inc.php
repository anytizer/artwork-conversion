<?php
namespace slicing;

use demo\provider;
use \dtos\filedto;

class fileuploader
{
    public function upload($fname="concepts", $artwork_path="/tmp")
    {
        $provider = new provider();

        $date = date("Y-m-d H:i:s");
        $artworks = array();
        foreach($_FILES[$fname]["tmp_name"] as $index => $tmp_name)
        {
            $id = $provider->id();
            $project = "";
            $name  = $_FILES[$fname]["name"][$index];
            $type = $_FILES[$fname]["type"][$index];
            $error = $_FILES[$fname]["error"][$index];
            $size  = $_FILES[$fname]["size"][$index];
            $path  = "{$artwork_path}/{$id}.upload";
            $active = "1";

            # @todo If error!=0, skip processing the file
            if(is_uploaded_file($tmp_name))
            {
                move_uploaded_file($tmp_name, $path);
                
                $file = new filedto();
                $file->id = $id;
                $file->project = $project;
                $file->name = $name;
                $file->type = $type;
                $file->error = $error;
                $file->size = $size;
                $file->path = $path;
                $file->active = $active;
                $file->date = $date;

                $artworks[] = $file;
            }
        } # foreach

        return $artworks;
    }
    
    
    // different scope
    public function artworks()
    {
        $pattern = __ROOT__."/store/concepts/*.upload";
        $files = glob($pattern);
        $files = array_map(function($path){
            $name = str_replace(__ROOT__."/store/concepts/", "", $path);
            $name = preg_replace("/.upload$/is", "", $name);
            $name = id($name);
            return $name;
        }, $files);
        #print_r($files);
        
        return $files;
    }
    
    public function maintenance()
    {
        // delete all uploaded files
        $pattern = __ROOT__."/store/concepts/*.upload";
        $files = glob($pattern);
        #print_r($files); die();
        $files = array_map(function($path){
            return unlink($path);
        }, $files);
        
        return $files;
    }
}
