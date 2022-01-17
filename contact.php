<?php

    $array = array("name" => "", "email" => "", "message" => "", "nameError" => "", "emailError" => "", "messageError" => "", "isSuccess" => false);
    $emailTo = "contact@gmx.fr";

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    { 
        $array["name"] = test_input($_POST["name"]);
        $array["email"] = test_input($_POST["email"]);
        $array["message"] = test_input($_POST["message"]);
        $array["isSuccess"] = true; 
        $emailText = "";
        
        if (empty($array["name"]))
        {
            $array["nameError"] = "Informations manquantes";
            $array["isSuccess"] = false; 
        } 
        else
        {
            $emailText .= "name: {$array['name']}\n";
        }

        if(!isEmail($array["email"])) 
        {
            $array["emailError"] = "Mauvais email";
            $array["isSuccess"] = false; 
        } 
        else
        {
            $emailText .= "email: {$array['email']}\n";
        }

        if (empty($array["message"]))
        {
            $array["messageError"] = "Message manquant";
            $array["isSuccess"] = false; 
        }
        else
        {
            $emailText .= "message: {$array['message']}\n";
        }
        
        if($array["isSuccess"]) 
        {
            $headers = "From: {$array['name']} <{$array['mail']}>\r\nReply-To: {$array['mail']}";
            mail($emailTo, "Un message de votre site", $emailText, $headers);
        }
        
        echo json_encode($array);
        
    }

    function isEmail($email) 
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    function isPhone($tel) 
    {
        return preg_match("/^[0-9 ]*$/",$tel);
    }
    function test_input($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
 
?>