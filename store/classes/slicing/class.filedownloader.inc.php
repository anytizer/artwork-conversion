<?php
namespace slicing;

use \dtos\filedto;
use \slicing\database;

class filedownloader extends database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function single($artwork_id=""): filedto
    {
        $select_sql="SELECT * FROM artworks WHERE artwork_id=:artwork_id LIMIT 1;";

        $statement = $this->database->prepare($select_sql);
        $statement->bindParam(":artwork_id", $artwork_id, SQLITE3_TEXT);

        $result = $statement->execute();
        $artwork = $result->fetchArray(SQLITE3_ASSOC);

        $filedto = new filedto();
        $filedto->id = $artwork["artwork_id"];
        $filedto->project = $artwork["project_id"];
        $filedto->name = $artwork["artwork_name"];
        $filedto->type = $artwork["artwork_type"];
        $filedto->error = $artwork["artwork_error"];
        $filedto->size = $artwork["artwork_size"];
        $filedto->path = $artwork["artwork_path"];
        $filedto->active = $artwork["artwork_active"];
        $filedto->date = $artwork["artwork_date"];

        return $filedto;
    }
}
