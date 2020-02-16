<?php
function smarty_modifier_currency($amount=0.00)
{
    return "$".number_format($amount, 2);
}
