<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Certifier AAEC</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Descripción de desarrollo para la app Certifier AAEC">

        <meta name="robots" content="noindex, nofollow">

        <style>
            @font-face {
                font-family: 'Ubuntu', sans-serif;
                font-weight: normal;
                font-style: normal;
            }

            :root {
                --custom-color: #009FE3;
            }

            .bg-custom-color {
                background-color: var(--custom-color) !important;
            }

            .btn-custom-color {
                background-color: var(--custom-color);
                border-color: var(--custom-color);
            }
        </style>
    </head>

    <body class="d-flex flex-column h-100">
        <main class="parent">
            <p>¡Hola!<p/>

            <p>Para completar el proceso de ingreso, por favor utilice el siguiente código de validación:</p>

            <p class="fw-bold">{{ $contents['code'] }}</p>

            <p class="text-custom-color">Certifier - AAEC</p>
        </main>
    </body>
</html>
