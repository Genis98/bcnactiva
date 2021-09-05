# Pasarelas de pago

### Introducción

Una pasarela de pago es un servicio de pago digital proporcionado por un tercero a los servicios de comercio electrónico.

- Autoriza pagos directos, billetera electrónica o tarjetas de crédito / débito en minoristas en línea, sitios web de comercio electrónico o tiendas físicas tradicionales.
- Proporciona a los minoristas acceso a servicios comerciales para procesar pagos de las principales instituciones financieras.

- Un proveedor de servicios de pasarela de pago mantiene segura la información confidencial proporcionada por los usuarios.

- Cifra los datos como datos bancarios o de tarjetas de los usuarios.

- El comerciante, el cliente, el banco emisor y el adquirente son los actores clave en el proceso de pago completo.

#### ¿Cómo funciona una pasarela de pago?

- Estos son los pasos básicos sobre cómo funciona una pasarela de pago:

    **Paso 1** : en la página de pago, el usuario realiza el pago haciendo clic en el botón.

    **Paso 2** : en el momento del pago, la plataforma de comercio electrónico pasa de forma segura información de pago confidencial a la página de host (pasarela de pago de terceros).

    **Paso 3** : a continuación, la pasarela de pago tokeniza los datos o la información del cliente y los envía al banco adquirente del comerciante.

    **Paso 4** : la adquisición verifica los detalles y envía una respuesta "aprobada" o "rechazada" a la pasarela de pago.

    **Paso 5** : la pasarela de pago envía la respuesta y el token al cliente.

    **Paso 6** : la información de pago se recibe y se almacena en la base de datos.

#### Dimensionamiento del sistema de pago

El tipo de sistema de pago vendrá determinado por los siguientes aspectos:

- **Numero de ventas estimadas**. Este punto determinará la potencia de los servidores y la estructura de base de datos, no es lo mismo el desarrollo para una tienda como Amazon, que para una pequeña tienda de barrio.

- **Ámbito geográfico de los clientes** (local, nacional, global). Este punto determinará las divisas a utilizar, transportes e impuestos.

- **Precio de los productos** en venta y de los pedidos comunes. A la hora de realizar el diseño de la web y la forma de mostrar precios.

- Si la venta es de **productos físicos o servicios** (no requieren envío). Si solo ofrecemos servicios o descargas no deberemos guardar direcciones físicas ni realizar envíos.

- **Criticidad** de los pagos y **concurrencia** de la aceptación del pago con los resultados en nuestra web. Este punto será importante para la implementación de transacciones en nuestra base de datos, si tenemos productos con stock, deberemos controlar en tiempo real su número para no permitir compras con stock cero.

#### Elementos necesarios

1.  Una base de datos donde guardar la siguiente información:
    - Información del cliente (nombre, dni, dirección fiscal).
    - Información del pedido
    - Líneas de pedido (productos)
    - Dirección de envío

2. Librerías y/o scripts que nos permitan la comunicación con la pasarela de pago del banco o entidad intermediaria (pj: Paypal).

### Integración con Paypal

![](https://imgur.com/XW0so9O.png)

PayPal tiene una reputación de confianza a nivel mundial.
Permite aceptar pagos on-line y móvil.
Procesa pagos con tarjeta o cuenta bancaria en 6 monedas. Y, los pagos vía PayPal en 26 monedas.
Requiere cierto nivel de configuración, pero permite la personalización y la finalización del pago dentro del sitio de compra.
Gestiona la privacidad de los datos de manera que se simplifica el cumplimiento de las normas de seguridad PCI(Payment Cards Industry).

El pago por PayPal tiene algunos inconvenientes:
- No es el ideal para negocios de subscripción.
- Es más cara que otras opciones.
- Los pagos internacionales están más limitados que con otras pasarelas (stripe).

### Pasos para integrar PayPal

#### 1. Registro en Sandbox

Para poder hacer uso de la pasarela de pago electrónico de Paypal en modo de pruebas necesitamos registrarnos como desarrolladores de paypal en su sistema de [*sandbox*](http://developer.paypal.com).

#### 2. Crear cuentas de prueba

Si no las tenemos, crearemos dos cuentas de pruebas asociadas: Una de comprador o **personal** y otra de vendedor o **business**

### Integración con Paypal Standard

1. Recuperación de la información de venta e incorporación de un botón de pago dentro de un formulario
    ```html
    <html>
    <title>Paypal Payment Gateway Integration in PHP</title>
    <head>
    <style>
    body {
        font-family: Arial;
        line-height: 30px;
        color: #333;
    }

    #payment-box {
        padding: 40px;
        margin: 20px;
        border: #E4E4E4 1px solid;
        display: inline-block;
        text-align: center;
        border-radius: 3px;
    }

    #pay_now {
        padding: 10px 30px;
        background: #09f;
        border: #038fec 1px solid;
        border-radius: 3px;
        color: #FFF;
        width: 100%;
        cursor: pointer;
    }

    .txt-title {
        margin: 25px 0px 0px 0px;
        color: #4e4e4e;
    }

    .txt-price {
        margin-bottom: 20px;
        color: #08926c;
        font-size: 1.1em;
    }
    </style>
    </head>
    <body>
        <div id="payment-box">
            <img src="images/camera.jpg" />
            <h4 class="txt-title">A6900 MirrorLess Camera</h4>
            <div class="txt-price">$289.61</div>
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr"
                method="post" target="_top">
                <input type='hidden' name='business'
                    value='bcncodes.academy@gmail.com'> <input type='hidden'
                    name='item_name' value='Camera'> <input type='hidden'
                    name='item_number' value='CAM#N1'> <input type='hidden'
                    name='amount' value='10'> <input type='hidden'
                    name='no_shipping' value='1'> <input type='hidden'
                    name='currency_code' value='USD'> <input type='hidden'
                    name='notify_url'
                    value='http://www.pruebapaypal.com.mialias.net/notify.php'>
                <input type='hidden' name='cancel_return'
                    value='http://127.0.0.1/paypal-example/cancel.php'>
                <input type='hidden' name='return'
                    value='http://127.0.0.1/paypal-example/return.php'>
                <input type="hidden" name="cmd" value="_xclick"> <input
                    type="submit" name="pay_now" id="pay_now"
                    Value="Pay Now">
            </form>
        </div>
    </body>
    </html>
    ```
2. Envío a paypal de la información necesaria para procesar el pago.

3. Programación de la página de regreso del pago.
    ```html
    <html>
    <head>
    <title>Order Placed</title>
    <style>
    .response-text {
        display: inline-block;
        max-width: 550px;
        margin: 0 auto;
        font-size: 1.5em;
        text-align: center;
        background: #fff3de;
        padding: 42px;
        border-radius: 3px;
        border: #f5e9d4 1px solid;
        font-family: arial;
        line-height: 34px;
    }
    </style>
    </head>
    <body>
        <div class="response-text">
            You have placed your order successfully.<br> Thank you for
            shopping with us!
        </div>
    </body>
    </html>
    ```
4. Programación de la página de cancelación del pago.

    ```html
    Sorry! Payment Cancelled.
    ```

5. Programación del listener de notificación de Paypal (IPN Listener)

```php
<?php

class PaypalIPN
{
    /** @var bool Indicates if the sandbox endpoint is used. */
    private $use_sandbox = false;
    /** @var bool Indicates if the local certificates are used. */
    private $use_local_certs = true;

    /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';
    /** Sandbox Postback URL */
    const SANDBOX_VERIFY_URI = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

    /** Response from PayPal indicating validation was successful */
    const VALID = 'VERIFIED';
    /** Response from PayPal indicating validation failed */
    const INVALID = 'INVALID';

    /**
     * Sets the IPN verification to sandbox mode (for use when testing,
     * should not be enabled in production).
     * @return void
     */
    public function useSandbox()
    {
        $this->use_sandbox = true;
    }

    /**
     * Sets curl to use php curl's built in certs (may be required in some
     * environments).
     * @return void
     */
    public function usePHPCerts()
    {
        $this->use_local_certs = false;
    }

    /**
     * Determine endpoint to post the verification data to.
     *
     * @return string
     */
    public function getPaypalUri()
    {
        if ($this->use_sandbox) {
            return self::SANDBOX_VERIFY_URI;
        } else {
            return self::VERIFY_URI;
        }
    }

    /**
     * Verification Function
     * Sends the incoming post data back to PayPal using the cURL library.
     *
     * @return bool
     * @throws Exception
     */
    public function verifyIPN()
    {
        if ( ! count($_POST)) {
            throw new Exception("Missing POST Data");
        }

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->getPaypalUri());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        if ($this->use_local_certs) {
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . "/cert/cacert.pem");
        }
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: PHP-IPN-Verification-Script',
            'Connection: Close',
        ));
        $res = curl_exec($ch);
        if ( ! ($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }

        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];
        if ($http_code != 200) {
            throw new Exception("PayPal responded with http code $http_code");
        }

        curl_close($ch);

        // Check if PayPal verifies the IPN data, and if so, return true.
        if ($res == self::VALID) {
            return true;
        } else {
            return false;
        }
    }
}
```

### Integración con Paypal Checkout

1. Creación de una APP Rest API

Dentro de la sección **My Apps & Credentials** de la cuenta developer, generamos el `client_id` y el secret de la cuenta.


2. Instalación de Paypal SDK

- Instalar Composer globalmente (Linux):

  ```bash
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"

    sudo mv composer.phar /usr/local/bin/composer
  ```

- Instalar PayPal SDK

   ```bash
   composer require paypal/paypal-checkout-sdk 1.0.1
   ```

2. Crear un fichero environment.php

```php

    const CLIENT_ID = $ENV('AR6UOuQpLraYfeAfpVxyi2dIpeWesCCEbv3NqxQE-p6u4D9rER6plpAykh90m1A_DMa5QOx6-wiWG82R');
    const CLIENT_SECRET = $ENV('EGAactBPThH4FeOWI3JN6-SXCJ0N1nuZSo1_0RrUBnbsLeCdqcyPplZ0yZN6d5UZajfgaQFGHfrgBhWc');

```

3. Crear el fichero `paypal-config.php`

```php

<?php

namespace Sample;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PaypalIPN
{
    /** @var bool Indicates if the sandbox endpoint is used. */
    private $use_sandbox = false;
    /** @var bool Indicates if the local certificates are used. */
    private $use_local_certs = true;

    /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';
    /** Sandbox Postback URL */
    const SANDBOX_VERIFY_URI = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

    /** Response from PayPal indicating validation was successful */
    const VALID = 'VERIFIED';
    /** Response from PayPal indicating validation failed */
    const INVALID = 'INVALID';

    /**
     * Sets the IPN verification to sandbox mode (for use when testing,
     * should not be enabled in production).
     * @return void
     */
    public function useSandbox()
    {
        $this->use_sandbox = true;
    }

    /**
     * Sets curl to use php curl's built in certs (may be required in some
     * environments).
     * @return void
     */
    public function usePHPCerts()
    {
        $this->use_local_certs = false;
    }

    /**
     * Determine endpoint to post the verification data to.
     *
     * @return string
     */
    public function getPaypalUri()
    {
        if ($this->use_sandbox) {
            return self::SANDBOX_VERIFY_URI;
        } else {
            return self::VERIFY_URI;
        }
    }

    /**
     * Verification Function
     * Sends the incoming post data back to PayPal using the cURL library.
     *
     * @return bool
     * @throws Exception
     */
    public function verifyIPN()
    {
        if ( ! count($_POST)) {
            throw new Exception("Missing POST Data");
        }

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->getPaypalUri());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        if ($this->use_local_certs) {
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . "/cert/cacert.pem");
        }
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: PHP-IPN-Verification-Script',
            'Connection: Close',
        ));
        $res = curl_exec($ch);
        if ( ! ($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }

        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];
        if ($http_code != 200) {
            throw new Exception("PayPal responded with http code $http_code");
        }

        curl_close($ch);

        // Check if PayPal verifies the IPN data, and if so, return true.
        if ($res == self::VALID) {
            return true;
        } else {
            return false;
        }
    }
}
```

### Pago con tarjeta vía Braintree Direct

Obtenemos las credenciales desde Braintree Sandbox Signup:
[ejemplo](https://github.com/braintree/braintree_php_example)



