<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Backend &bull; Log in</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=quicksand:400,600" rel="stylesheet" />

    <link href="/assets/css/main.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100 flex min-h-screen justify-center items-center p-6">
    {{ $slot }}

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons()</script>
  </body>
</html>
