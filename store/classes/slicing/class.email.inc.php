<?php
namespace slicing;

use \dtos\userdto;
use PHPMailer\PHPMailer\PHPMailer;

class email extends PHPMailer
{
    public function __construct()
    {
        parent::__construct();
        
        $smtp = (new configs())->section("smtp");
        
        $this->SMTPDebug = 0;
        $this->isSMTP();
        $this->Timeout = 10;
        $this->SMTPKeepAlive = true;
        $this->Host = $smtp["hostname"];
        $this->SMTPAuth = true;
        $this->SMTPAutoTLS = false;
        $this->Username = $smtp["username"];
        $this->Password = $smtp["password"];
        $this->SMTPSecure = $smtp["encryption"];
        $this->Port = $smtp["port"];
        $this->From = $smtp["from"];
        $this->FromName = $smtp["name"];
        $this->isHTML(true);
    }
    
    private function template($file="")
    {
        $template_path = __ROOT__."/store/emails/{$file}";
        return file_get_contents($template_path);
    }

    /**
     * 
     * @todo Parameterize to pass template name, subject, data, and recipient.
     */
    public function deliver()
    {
        $email_template = "customer-welcome.html";
        $html = $this->template($email_template);

        $email_template = "customer-welcome.txt";
        $text = $this->template($email_template);

        $this->Subject = "Test Email";
        $this->Body = $html;
        $this->AltBody = $text;

        # @todo do not SEND emails during tests
        #$sent = $this->send();
        $sent = false;
        return $sent;
    }


    /**
     * Send activation link to the customer
     *
     * @param userdto $customer
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function activate_customer(userdto $customer): bool
    {
        global $websites;

        $html = $this->template("customer-welcome.html");
        $text = $this->template("customer-welcome.txt");

        $html = str_replace("{CUSTOMER}",  $customer->name, $html);
        $text = str_replace("{CUSTOMER}",  $customer->name, $text);

        $html = str_replace("{ACTIVATION_LINK}",  "<a href='{$websites['hooks']}/activate.php?code={$customer->code}'>{$customer->code}</a>", $html);
        $text = str_replace("{ACTIVATION_LINK}",  "{$websites['hooks']}/activate.php?code={$customer->code}", $text);

        $this->addAddress($customer->email, $customer->name);
        $this->Subject = "Customer Activation";
        $this->Body = $html;
        $this->AltBody = $text;

        # @todo do not SEND emails during tests
        $sent = $this->send();
        #$sent = false;
        return $sent;
    }
}
