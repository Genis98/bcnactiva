<?php

require_once("dbcontroller.php");
$db_handle = new DBController();

$sql = "SELECT first_name, dob, phone FROM employees_data";

$result = $db_handle->runQuery($sql);

//print_r($result);


$format = "m/d";
$today = date($format);
echo($today);
echo("\n");
foreach ($result as $employee) {
    $dob = date($format, strtotime($employee['dob']));
    // print_r($dob);
    echo($dob);
    //   print_r($today==$dob);
    echo($today==$dob?'birthday':'no son iguales');
    echo("\n");
}