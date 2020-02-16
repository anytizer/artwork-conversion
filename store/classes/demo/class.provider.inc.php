<?php
namespace demo;

use dtos\userdto;
use anytizer\guid;

class provider
{
    private function firstname()
    {
        $data = ["David", "Ronda", "John", "Jane", "James", "Maria"];
        $random = $data[array_rand($data)];
        
        return $random;
    }
    
    private function lastname()
    {
        $data = ["Buttler", "Blunt", "Chad", "Wild", "Hunter", "Thumpson"];
        $random = $data[array_rand($data)];
        
        return $random;
    }
    
    public function name()
    {
        $name = $this->firstname()." ".$this->lastname();
        return $name;
    }
    
    public function email()
    {
        $email = $this->id()."@example.com";
        return $email;
    }
    
    public function code()
    {
        $code = md5(password_plain());
        return $code;
    }
    
    public function id()
    {
        $id = (new guid())->NewGuid();
        return $id;
    }
    
    public function phonenumber()
    {
        $a = mt_rand(100, 999);
        $b = mt_rand(100, 999);
        $c = mt_rand(1000, 9999);
        $phonenumber = "{$a}-{$b}-{$c}";
        
        return $phonenumber;
    }

    /**
     * Provide an unregistered DTO
     */
    public function get_unregistered_customer(): userdto
    {
        $password_plain = password_plain();
        
        $userdto = new userdto();
        $userdto->id = (new guid())->NewGuid();
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
}
