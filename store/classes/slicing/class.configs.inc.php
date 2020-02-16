<?php
namespace slicing;

class configs
{
    private $configs = [];
    
    public function __construct()
    {
        $configs = parse_ini_file(__ROOT__."/configs.ini", true);
        $this->configs = $configs;
    }

    public function section($section="")
    {
        $ini = [];
        if(array_key_exists($section, $this->configs))
        {
            $ini = $this->configs[$section];
        }
        else
        {
            trigger_error("Cannot read configuration block: {$section}.");
        }

        return $ini;
    }
}
