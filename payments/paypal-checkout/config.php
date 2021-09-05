<?php
define('ProPayPal', 0);
if(ProPayPal){
    define("PayPalClientId", "*********************");
    define("PayPalSecret", "*********************");
    define("PayPalBaseUrl", "https://api.paypal.com/v1/");
    define("PayPalENV", "production");
} else {
    define("PayPalClientId", "AR6UOuQpLraYfeAfpVxyi2dIpeWesCCEbv3NqxQE-p6u4D9rER6plpAykh90m1A_DMa5QOx6-wiWG82R");
    define("PayPalSecret", "EGAactBPThH4FeOWI3JN6-SXCJ0N1nuZSo1_0RrUBnbsLeCdqcyPplZ0yZN6d5UZajfgaQFGHfrgBhWc");
    define("PayPalBaseUrl", "https://api.sandbox.paypal.com/v2/checkout/");
    define("PayPalENV", "sandbox");
}
?>
