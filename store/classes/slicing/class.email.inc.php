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

        $content = "";
        if(file_exists($template_path))
        {
            $content = file_get_contents($template_path);
        }

        return $content;
    }

    private function replace($find=[], $content="")
    {
        $content = str_replace(array_keys($find), array_values($find), $content);
        return $content;
    }

    private function deliver(): bool
    {
        $sent = false;

        // The only point to send emails through out the application
        if(__LINE__)
        {
            $sent = $this->send();
        }

        return $sent;
    }

    // customer: upload.php
    /**
     * Send activation link to the customer
     *
     * @param userdto $customer
     * @param string $password_plain
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function activate_customer(userdto $customer, $password_plain=""): bool
    {
        global $company;
        global $websites;

        $find = array(
            "{CUSTOMER}" => $customer->name,
            "{ACTIVATION_LINK}" => "{$websites['hooks']}/activate.php?id={$customer->id}&code={$customer->code}",
            "{PASSWORD}" => $password_plain,
            "{COMPANY}" => $company["name"],
        );

        $html = $this->replace($find, $this->template("customer-welcome.html"));
        $text = $this->replace($find, $this->template("customer-welcome.txt"));
        #die($text);

        $this->addAddress($customer->email, $customer->name);
        $this->Subject = "Customer - Activation Required";
        $this->Body = $html;
        $this->AltBody = $text;

        return $this->deliver();
    }

    // customer: payment.php
    public function payment_received($project_id=""): bool
    {
        global $websites;
        global $company;

        $project = new project();
        $projectdto = $project->single($project_id);

        $customer = new customer();
        $customerdto = $customer->single($projectdto->customer);

        $find = array(
            "{CUSTOMER}" => $customerdto->name,
            "{BUDGET}" => $projectdto->paid,
            "{PROJECT}" => $projectdto->name,
            "{WEBSITE}" => $websites["customer"],
            "{COMPANY}" => $company["name"],
        );

        $html = $this->replace($find, $this->template("payment-received.html"));
        $text = $this->replace($find, $this->template("payment-received.txt"));

        $this->addAddress($customerdto->email, $customerdto->name);
        $this->Subject = "Payment Received, Thanks";
        $this->Body = $html;
        $this->AltBody = $text;

        return $this->deliver();
    }

    // customer: upload-again.php
    public function upload_again($project_id=""): bool
    {
        global $company;
        global $websites;

        $project = new project();
        $projectdto = $project->single($project_id);

        $customer = new customer();
        $customerdto = $customer->single($projectdto->customer);

        $find = array(
            "{CUSTOMER}" => $customerdto->name,
            "{BUDGET}" => $projectdto->budget,
            "{PROJECT}" => $projectdto->name,
            "{COMPANY}" => $company["name"],
        );

        $html = $this->replace($find, $this->template("customer-project-uploaded.html"));
        $text = $this->replace($find, $this->template("customer-project-uploaded.txt"));

        $this->addAddress($customerdto->email, $customerdto->name);
        $this->Subject = "Project being estimated";
        $this->Body = $html;
        $this->AltBody = $text;

        return $this->deliver();
    }

    // admin: estimate.php
    public function ask_payment($project_id=""): bool
    {
        #die("Project ID: {$project_id}.");
        global $company;
        global $websites;

        $project = new project();
        $projectdto = $project->single($project_id);

        $customer = new customer();
        $customerdto = $customer->single($projectdto->customer);
        #print_r($customerdto); die();

        $find = array(
            "{CUSTOMER}" => $customerdto->name,
            "{BUDGET}" => $projectdto->budget,
            "{PROJECT}" => $projectdto->name,
            "{PROJECTID}" => $projectdto->id,
            "{WEBSITE}" => $websites["customer"],
            "{COMPANY}" => $company["name"],
        );

        $html = $this->replace($find, $this->template("customer-project-payment-ask.html"));
        $text = $this->replace($find, $this->template("customer-project-payment-ask.txt"));

        $this->addAddress($customerdto->email, $customerdto->name);
        $this->Subject = "Project Estimated, Please pay";
        $this->Body = $html;
        $this->AltBody = $text;

        return $this->deliver();
    }

    // admin: project-terminate.php
    public function terminate_project($project_id=""): bool
    {
        global $company;
        global $websites;

        $project = new project();
        $projectdto = $project->single($project_id);

        $customer = new customer();
        $customerdto = $customer->single($projectdto->customer);
        #print_r($customerdto); die();

        $find = array(
            "{CUSTOMER}" => $customerdto->name,
            "{PROJECT}" => $projectdto->name,
            "{COMPANY}" => $company["name"],
        );

        $html = $this->replace($find, $this->template("project-terminated.html"));
        $text = $this->replace($find, $this->template("project-terminated.txt"));

        $this->addAddress($customerdto->email, $customerdto->name);
        $this->Subject = "Your project is terminated.";
        $this->Body = $html;
        $this->AltBody = $text;

        return $this->deliver();
    }

    // admin.php: developer-flag-onboarded.php
    public function developer_onboarded($developer_id=""): bool
    {
        global $company;
        global $websites;

        $developer = new developer();
        $developerdto = $developer->single($developer_id);

        $find = array(
            "{DEVELOPER}" => $developerdto->name,
            "{ACTIVATION_LINK}" => "{$websites['customer']}/developer-activate.php?id={$developerdto->id}&code={$developerdto->code}",
            "{COMPANY}" => $company["name"],
        );

        $html = $this->replace($find, $this->template("developer-onboarded.html"));
        $text = $this->replace($find, $this->template("developer-onboarded.txt"));

        $this->addAddress($developerdto->email, $developerdto->name);
        $this->Subject = "You have been Onboarded";
        $this->Body = $html;
        $this->AltBody = $text;

        return $this->deliver();
    }
}
