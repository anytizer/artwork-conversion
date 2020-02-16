<?php
function smarty_modifier_artworkdate($guid="")
{
    $artwork = __ROOT__."/store/concepts/{$guid}.upload";
    return date("Y-m-d H:i:s", filectime($artwork));
}
