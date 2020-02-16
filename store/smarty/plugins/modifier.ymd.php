<?php
function smarty_modifier_ymd($date="0000-00-00 00:00:00")
{
    return substr($date, 0, 10);
}
