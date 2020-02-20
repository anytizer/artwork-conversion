<?php
require_once "inc.config.php";

$password_plain = password_plain();
$password_encrypted = password($password_plain);
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Project</title>
    <meta name="description" content="We convert your concept/artwork into computer software and website." />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="assets/public_html/css/w3.css" />
</head>
<body>
<div class="wrapper">
    <div class="w3-black w3-padding">|
        <a class="w3-btn w3-blue" href="customers/public_html/">Customer</a> |
        <a class="w3-btn w3-teal" href="admin/public_html/">Admin</a> |
        <a class="w3-btn w3-purple" href="developer/public_html/">Developer</a> |
        <a class="w3-btn w3-yellow" href="info.php">PHP Info</a> |
        <a class="w3-btn w3-yellow" href="messages.log">Messages</a> |
        <a class="w3-btn w3-red" href="autolog.php">AutoLog</a> |
    </div>
    <div class="w3-padding">
        <strong>Server Time</strong>: <?php echo date("Y-m-d H:i:s"); ?><br />
        <strong>Plain Password</strong>: <?php echo $password_plain; ?><br />
        <strong>Encrypted Password</strong>: <?php echo $password_encrypted; ?><br />
        <br />
        <strong>SQLs</strong>:<br />
        UPDATE customers SET customer_password='<?php echo $password_encrypted; ?>';<br />
        UPDATE admin SET admin_password='<?php echo $password_encrypted; ?>';<br />
    </div>
</div>
</body>
</html>
