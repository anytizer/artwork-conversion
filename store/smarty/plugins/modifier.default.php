<?php
function smarty_modifier_default($value="", $default="")
{
    return $value??$default;
}
