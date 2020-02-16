<?php
function smarty_modifier_artworksize($guid="")
{
    $artwork = __ROOT__."/store/concepts/{$guid}.upload";
    return filesize($artwork);
}
