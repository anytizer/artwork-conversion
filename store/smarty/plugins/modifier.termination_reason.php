<?php
use \demo\provider;

function smarty_modifier_termination_reason($reason="0")
{
    $provider = new provider();
    $reasons = $provider->termination_reasons();

    $name = "Unknown";
    if(in_array($reason, array_keys($reasons)))
    {
        $name = $reasons[$reason];
    }
    
    return $name;
}
