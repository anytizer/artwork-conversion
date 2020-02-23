<?php
function smarty_modifier_termination_reason($reason="0")
{
    $provider = new \demo\provider();
    $reasons = $provider->termination_reasons();

    // SELECT * FROM terminations;


    $name = "Unknown";
    if(in_array($reason, array_keys($reasons)))
    {
        $name = $reasons[$reason];
    }
    
    // @todo Use a global database provider

    return $name;
}
