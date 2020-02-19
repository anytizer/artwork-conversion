<?php
require_once "inc.config.php";

$password_plain = password_plain();
$password_encrypted = password($password_plain);

?>
<a href="customers/public_html/">Customer</a> |
<a href="admin/public_html/">Admin</a> |
<a href="developer/public_html/">Developer</a>
<hr/>
Server Time: <?php echo date("Y-m-d H:i:s"); ?><br />
Plain Password: <?php echo $password_plain; ?><br />
Encrypted Password: <?php echo $password_encrypted; ?><br />
SQL:<br />
UPDATE customers SET customer_password='<?php echo $password_encrypted; ?>';<br />
