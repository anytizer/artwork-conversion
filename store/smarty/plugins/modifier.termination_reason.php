<?php
function smarty_modifier_termination_reason($reason="0")
{
    // SELECT * FROM terminations;
    $reasons = [
        "0" => "Active",
        "1" => "Beyond Capacity",
        "2" => "Customer Won't Pay",
        "3" => "Refunded",
        "4" => "Project Successful",
    ];
    
    // @todo Catch array bound out of index

    return $reasons[$reason];
}
