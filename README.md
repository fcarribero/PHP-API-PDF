# advans/php-api-pdf

[![Latest Stable Version](https://img.shields.io/packagist/v/advans/php-api-pdf?style=flat-square)](https://packagist.org/packages/advans/php-api-pdf)
[![Total Downloads](https://img.shields.io/packagist/dt/advans/php-api-pdf?style=flat-square)](https://packagist.org/packages/advans/php-api-pdf)

## Instalación usando Composer

```sh
$ composer require advans/php-api-pdf
```

## Ejemplo

````
$service_pdf = new \Advans\Api\Pdf\Pdf([
    'base_url' => '*************************',
    'key' => '**********************'
]);

$fo = file_get_contents('fo_example.xml');
$response = $service_pdf->fromFormatObject($fo);
````

## Configuración

| Parámetro | Valor por defecto | Descripción |
| :--- | :--- | :--- |
| base_url | null | URL de la API |
| key | null | API Key |
| use_exceptions | true | Define si una respuesta con error dispara un Exception
