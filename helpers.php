<?php

use App\Database\Database;

function basePath()
{
    return __DIR__;
}

function baseURL()
{
    $config = new \App\Utility\Config();

    return $config->get('url');
}

function clean_input($data) {
    if(!is_string($data))
        return $data;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getProducts(){

    $database = new Database();
    $aux = $database->select("products");
    //var_dump($aux);
    $rez = [];
    foreach ($aux as $e){
        $rez[$e['id']] = $e;
    }
    return $rez;
}

function generateToken($len = 15){
    $str = join("",range('a','z')) . join("",range('A','Z')) . join("",range('0','9'));
    return substr(str_shuffle($str),0,$len);
}

function sendConfirmationEmail($email,$token){

    $emailSender = (new \App\Utility\Config())->get('email');

    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls')) ->setUsername($emailSender['address']) ->setPassword($emailSender['password']);
    $mailer = new Swift_Mailer($transport);
    // Create a message
    $message = (new Swift_Message('Validate your account'))
        ->setFrom([$emailSender['address'] => 'eCommerce'])
//        ->setTo(['novituha@direct-mail.top'])
         ->setTo([$email])
        ->setBody('Click this link to validate your account: \n https://catalinsbera.beta.bitstone.eu/confirm?token=' . $token);
    // Send the message
    $mailer->send($message);
}

function sendEmailWithTitleAndBody($email,$title,$body,$attachment = null){

    $emailSender = (new \App\Utility\Config())->get('email');

    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls')) ->setUsername($emailSender['address']) ->setPassword($emailSender['password']);
    $mailer = new Swift_Mailer($transport);
    var_dump($email);
//    exit;
    // Create a message
    $message = (new Swift_Message($title))
        ->setFrom([$emailSender['address'] => 'eCommerce'])
//        ->setTo(['ciwib@ionemail.net'])
         ->setTo([$email])
        ->setBody($body);
    if(isset($attachment))
        $message->attach(Swift_Attachment::fromPath($attachment)->setFilename("Order.pdf"));
    // Send the message
    $mailer->send($message);
}

function appPath()
{
    return __DIR__.'/app';
}

function styleUrl($filename)
{
    $config = new \App\Utility\Config();

    return $config->get('url').'/styles/'.$filename;
}

function scriptUrl($filename)
{
    $config = new \App\Utility\Config();

    return $config->get('url').'/scripts/'.$filename;
}

function iconUrl(){
    $config = new \App\Utility\Config();

    return $config->get('url')."/img/logo.ico";
}

