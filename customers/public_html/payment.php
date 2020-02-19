<?php
namespace customers;

require_once "../inc.config.php";

use \slicing\email;
use \slicing\hook;

#print_r($_POST);
# payment hook to be called

//if(__LIVE__)
{
    $hook = new hook();

    $project_id = id($_POST["project"]);
    $hook->mark_project_paid($project_id, $_POST["budget"], "REF".mt_rand(100, 999), "Web");

    $email = new email();
    $email->payment_received($project_id);
}
//else
{
    // @todo Fix the live mode hooks
    // Live mode should use IPN Hook.
}

/**

Array
(
    [budget] => 567
    [project] => EEA6C9BE-1F69-E7C7-E330-CE8092D0FFEA
    [pay] => Pay
)

*/
#die("Marked as paid...");
#header("Location: https://www.paypal.com/ca/home"); # go here
header("Location: project.php?id={$project_id}"); # payment successful redirect link
# this page: Payment success hook call.
