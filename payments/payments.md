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

2. Envío a paypal de la información necesaria para procesar el pago.

3. Programación de la página de regreso del pago.

4. Programación de la página de cancelación del pago.

5. Programación del listener de notificación de Paypal (IPN Listener)

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
3. Crear el fichero paypal-config.php

```php
   <?php

namespace Sample;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
# Pasarelas de pago

### Introducción

Una pasarela de pago es un servicio de pago digital proporcionado por un tercero a los servicios de comercio electrónico.

- Autoriza pagos directos, billetera electrónica o tarjetas de crédito / débito en minoristas en línea, sitios web de comercio electrónico o tiendas físicas tradicionales.
- Proporciona a los minoristas acceso a servicios comerciales para procesar pagos de las principales instituciones financieras.

#### ¿Cómo funciona una pasarela de pago?

- Un proveedor de servicios de pasarela de pago mantiene segura la información confidencial proporcionada por los usuarios.
- Cifra los datos como datos bancarios o de tarjetas de los usuarios.
- El comerciante, el cliente, el banco emisor y el adquirente son los actores clave en el proceso de pago completo.

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

![](https://imgur.com/XW0so9O)

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

2. Envío a paypal de la información necesaria para procesar el pago.

3. Programación de la página de regreso del pago.

4. Programación de la página de cancelación del pago.

5. Programación del listener de notificación de Paypal (IPN Listener)


Implementació de sistemes de pagament on-line
Introducció a les passarel·les de pagament on-line
PayPal Standard
Exemple d'implementació d'un botó de pagament mitjançant PayPal Standard.
PayPal CheckOut
Obtenció de credencials de PayPal per als entorns de desenvolupament i producció
Instal·lació i utilització del PayPal REST SDKs
Creació d'un Pagament usant PayPal REST API
Execució i confirmació del pagament PayPal*
Emmagatzematge dels detalls del pagament
*Es portaran a terme totes les passes necessàries per arribar a fer el pagament a l'entorn de
desenvolupament de PayPal (sandbox) dins d'un exemple replicat pels alumnes.


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
3. Crear el fichero paypal-config.php

```php
   <?php

namespace Sample;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     * This sample uses SandboxEnvironment. In production, use LiveEnvironment.
     */
    public static function environment()
    {
        $clientId = getenv("CLIENT_ID") ?: "PAYPAL-SANDBOX-CLIENT-ID";
        $clientSecret = getenv("CLIENT_SECRET") ?: "PAYPAL-SANDBOX-CLIENT-SECRET";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
```

### Pago con tarjeta vía Braintree Direct

Obtenemos las credenciales desde Braintree Sandbox Signup:
[ejemplo](https://github.com/braintree/braintree_php_example)




class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     * This sample uses SandboxEnvironment. In production, use LiveEnvironment.
     */
    public static function environment()
    {
        $clientId = getenv("CLIENT_ID") ?: "PAYPAL-SANDBOX-CLIENT-ID";
        $clientSecret = getenv("CLIENT_SECRET") ?: "PAYPAL-SANDBOX-CLIENT-SECRET";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
```

### Pago con tarjeta vía Braintree Direct

Obtenemos las credenciales desde Braintree Sandbox Signup:
[ejemplo](https://github.com/braintree/braintree_php_example)



