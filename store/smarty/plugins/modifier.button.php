<?php
function smarty_modifier_button($value=0)
{
    $class = !$value?"w3-btn w3-teal":"";
    return $class;
}
