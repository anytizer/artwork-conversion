<?php
namespace slicing;

use \dtos\projectdto;
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
     * Email Delivery Test
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
        return $this->send();
    }


    /**
     * Send activation link to the customer
     * @see upload.php
     *
     * @param userdto $customer
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function activate_customer(userdto $customer): bool
    {
        global $company;
        global $websites;

        $html = $this->template("customer-welcome.html");
        $text = $this->template("customer-welcome.txt");

        $find = array(
            "{CUSTOMER}" => $customer->name,
            "{ACTIVATION_LINK}" => "{$websites['hooks']}/activate.php?code={$customer->code}",
            "{PASSWORD}" => $customer->password,
            "{COMPANY}" => $company["name"],
        );

        $html = str_replace(array_keys($find), array_values($find), $html);
        $text = str_replace(array_keys($find), array_values($find), $text);
        #die($text);

        $this->addAddress($customer->email, $customer->name);
        $this->Subject = "Customer - Activation Required";
        $this->Body = $html;
        $this->AltBody = $text;

        # @todo do not SEND emails during tests
        return $this->send();
    }

    public function upload_again($project_id="")
    {
        global $company;
        global $websites;

        $project = new project();
        $projectdto = $project->single($project_id);
        $customer = new customer();
        $customerdto = $customer->single($projectdto->customer);

        $html = $this->template("customer-project-uploaded.html");
        $text = $this->template("customer-project-uploaded.txt");

        $find = array(
            "{CUSTOMER}" => $customerdto->name,
            "{BUDGET}" => $projectdto->budget,
            "{PROJECT}" => $projectdto->name,
            "{COMPANY}" => $company["name"],
        );

        $html = str_replace(array_keys($find), array_values($find), $html);
        $text = str_replace(array_keys($find), array_values($find), $text);
        #die($text);

        $this->addAddress($customerdto->email, $customerdto->name);
        $this->Subject = "Project being estimated";
        $this->Body = $html;
        $this->AltBody = $text;

        # @todo do not SEND emails during tests
        return $this->send();
    }




    // admin: estimate.php
    public function ask_payment($project_id="")
    {
        #die("Project ID: {$project_id}.");
        global $company;
        global $websites;

        $project = new project();
        $projectdto = $project->single($project_id);
        $customer = new customer();
        $customerdto = $customer->single($projectdto->customer);
        #print_r($customerdto); die();

        $html = $this->template("customer-project-payment-ask.html");
        $text = $this->template("customer-project-payment-ask.txt");

        $find = array(
            "{CUSTOMER}" => $customerdto->name,
            "{BUDGET}" => $projectdto->budget,
            "{PROJECT}" => $projectdto->name,
            "{PROJECTID}" => $projectdto->id,
            "{WEBSITE}" => $websites["customer"],
            "{COMPANY}" => $company["name"],
        );

        $html = str_replace(array_keys($find), array_values($find), $html);
        $text = str_replace(array_keys($find), array_values($find), $text);
        #die($text);

        $this->addAddress($customerdto->email, $customerdto->name);
        $this->Subject = "Project Estimated, Please pay";
        $this->Body = $html;
        $this->AltBody = $text;

        # @todo do not SEND emails during tests
        return $this->send();
    }
}
