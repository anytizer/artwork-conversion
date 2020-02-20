<?php
namespace customers;

require_once "../inc.config.php";

use \dtos\userdto;
use \dtos\projectdto;
use \slicing\email;
use \slicing\fileuploader;
use \slicing\customer;
use \slicing\project;
use anytizer\guid;

$artworks = [];
$fname = "concepts";
if(empty($_FILES[$fname]))
{
    die("Artwork not uploaded Or, too big file.");
}

if(empty($_FILES[$fname]["name"][0]))
{
    die("Artwork not uploaded Or, too big file.");
}

if(!$_POST["email"])
{
    die("Missing email address.");
}

# upload files
# create customer
# create project
# create project artwork attachment
# email customer
# email admin

$password_plain = password_plain();

$userdto = new userdto();
$userdto->id = $_SESSION["customer"]??(new guid())->NewGuid();
$userdto->name = $_POST["fullname"];
$userdto->email = $_POST["email"];
$userdto->password = password($password_plain);
$userdto->code = md5(password_plain());
$userdto->active = "0"; // will activate through email link

$customer = new customer();
if(empty($_SESSION["customer"]))
{
    $customer_created = $customer->create($userdto);
    if(!$customer_created)
    {
        die("Please supply a unique email address.");
    }
    else
    {
        # @todo Send an email asking to activate the customer profile/email.
        file_put_contents(__ROOT__."/activate.log", "\r\n{$websites['hooks']}/activate.php?code={$userdto->code}", FILE_APPEND);

        $mailer = new email();
        $mailer->activate_customer($userdto, $password_plain);
    }
}

$projectdto = new projectdto();
$projectdto->id = (new guid())->NewGuid();
#$projectdto->customer = $userdto->id;
$projectdto->name = $_FILES[$fname]["name"][0]." - ".mt_rand(1000, 9999);
$projectdto->date = date("Y-m-d H:i:s");
$projectdto->budget = "0.00";
$projectdto->paid = "0.00";
$projectdto->active = "1";
$projectdto->terminated = "0";

$project = new project();
$project_created = $project->create($userdto, $projectdto);

$fu = new fileuploader();
$artworks = $fu->upload($fname, $concepts_artwork_path);

$project->attach_artwork($projectdto, $artworks);

# @todo Send an email to the customer and admin

# Login the new* customer immediately
# Even though the customer has NOT activated email link
$_SESSION["customer"] = $userdto->id;
$_SESSION["name"] = $userdto->name;

header("Location: projects-recent.php");
