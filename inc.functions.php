<?php
/**
 * @return string Random password generator
 */
function password_plain()
{
    # alpha
    # numeric
    # multi cased
    # symbols
    # difficult

    # Scrambled combinations
    $uppercase = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
    $lowercase = str_shuffle("abcdefghijklmnopqrstuvwxyz");
    $numeric = str_shuffle("0123456789");
    $symbols = str_shuffle("@#\$%{}[];!?");

    $plain = "";
    $plain .= substr($uppercase, 0, mt_rand(3, 5));
    $plain .= substr($symbols, 0, mt_rand(3, 5));
    $plain .= substr($lowercase, 0, mt_rand(3, 5));
    $plain .= substr($numeric, 0, mt_rand(3, 5));
    return $plain;
}

/**
 * @param string $something
 * @return false|string|null
 */
function password($something="")
{
    $hash = password_hash($something, PASSWORD_DEFAULT);
    return $hash;
}

/**
 * @param string $id
 * @return string|string[]|null
 */
function id($id="")
{
    $guid = preg_replace("/[^A-F0-9\-]/s", "", $id);
    if(strlen($guid)!=36)
    {
        trigger_error("Invalid ID format.");
    }
    
    return $guid;
}
