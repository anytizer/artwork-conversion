<?php
function smarty_modifier_gravatar($email="")
{
    $hash = md5(strtolower(trim($email)));
    $gravatar = "https://www.gravatar.com/avatar/{$hash}?s=50";
    return $gravatar;
}
