<?php
namespace slicing;
use \SQLite3;

abstract class database
{
    protected $database = null;
    public function __construct()
    {
        /**
         * Extended classes should NOT have their __construct().
         * Or, must implement: parent::__construct();
         */
        $database_file = __ROOT__."/store/database/slicing.db";
        $mode = SQLITE3_OPEN_READWRITE;
        $encryption_key = "";
        
        # attempt to write a readonly database
        $this->database = new SQLite3($database_file, $mode, $encryption_key);
        $this->database->busyTimeout(1500);
        
        # PRAGMA foreign_keys = ON;
    }

    public function backup(): bool
    {
        $database_file = __ROOT__."/store/database/slicing.db";
        
        $ymdhis = date("YmdHis");
        $destination_file = __ROOT__."/store/database/_slicing-{$ymdhis}.db";
        
        $success = copy($database_file, $destination_file);
        return $success;
    }
    
    public function __destruct()
    {
        $this->database->close();
    }
}
