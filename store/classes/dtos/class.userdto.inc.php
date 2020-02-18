<?php
namespace dtos;

class userdto
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $code;
    public $active;
    
    public $onboarded; // Developer Flag
    public $total; // Customer's projects count
}
