<?php
namespace demo;

use \dtos\userdto;
use anytizer\guid;

class provider
{
    private function firstname()
    {
        $data = ["David", "Ronda", "John", "Jane", "James", "Maria"];
        return $data[array_rand($data)];
    }
    
    private function lastname()
    {
        $data = ["Buttler", "Blunt", "Chad", "Wild", "Hunter", "Thumpson"];
        return $data[array_rand($data)];
    }
    
    public function name()
    {
        return $this->firstname()." ".$this->lastname();
    }
    
    public function email()
    {
        return $this->id()."@example.com";
    }
    
    public function code()
    {
        return md5(password_plain());
    }
    
    public function id()
    {
        return (new guid())->NewGuid();
    }
    
    public function phonenumber()
    {
        $a = mt_rand(100, 999);
        $b = mt_rand(100, 999);
        $c = mt_rand(1000, 9999);
        return "{$a}-{$b}-{$c}";
    }

    /**
     * Provide an unregistered DTO
     */
    public function get_unregistered_customer(): userdto
    {
        $password_plain = password_plain();
        
        $userdto = new userdto();
        $userdto->id = $this->id();
        $userdto->name = $this->name();
        $userdto->email = "{$userdto->id}@example.com";
        $userdto->password = password($password_plain);
        $userdto->code = $this->code();
        $userdto->active = "0";
        
//        // log the customer temporarily
//        file_put_contents(__ROOT__."/customers.log", "
//{$userdto->email} - {$password_plain}
//", FILE_APPEND);
        
        return $userdto;
    }

    public function statuses()
    {
        return [
            "New Project",
            "In Dues",
            "Paid",
            "Terminated",
        ];
    }

    public function termination_reasons()
    {
        return [
            "0" => "Active",
            "1" => "Beyond Capacity",
            "2" => "Customer Won't Pay",
            "3" => "Refunded",
            "4" => "Project Successful",
        ];
    }
}
