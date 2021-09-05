<?php

require_once './vendor/autoload.php';
require_once("dbcontroller.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Twilio\Rest\Client;
function setClient(){
// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid =   $_ENV["TWILIO_ACCOUNT_SID"];
$token = $_ENV["TWILIO_AUTH_TOKEN"];
#$sid=   "ACee5ea9244476a278b30c1c68ec9a033b";
#$token="fba6fec6e019bc7864beab4e7949c6ca";

return new Client($sid, $token);


}
function sendMessage($employee){

$twilio = setClient();
$congrats=[];

$message =  $twilio->messages->create("whatsapp:{$employee['phone']}",
                         [
                             "from" => "whatsapp:+14155238886",
                             "body" => "happy birthday ".$employee['first_name']
                         ]);

if (isset($message)){
    print($message->sid);
    // $congrats[array(
    //     'name'=>$employee['first_name'],
    //     'congrat'=>true,
    //     'messageID'=>'ok'

    // )];
  }


//$message = $twilio->messages
/*                   ->create("whatsapp:+34650399412", // to
                           [
                               "from" => "whatsapp:+14155238886",
                               "body" => "Hello, there!"
                           ]
                  );
 */

//print($message->sid);
// return $congrats;
}

function checkBirthday(){
    $db_handle = new DBController();

    $sql = "SELECT first_name, dob, phone FROM employees_data";

    $result = $db_handle->runQuery($sql);

    $format = "m/d";
    $today = date($format);

    foreach ($result as $employee) {
        $dob = date($format, strtotime($employee['dob']));

        if($today==$dob){
        //    $messageOK = sendMessage($employee);
        sendMessage($employee);
        //    print_r($messageOK);
        }

    }
}

checkBirthday();
