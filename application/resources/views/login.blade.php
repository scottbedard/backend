<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/@bedard/gradient@0.1.2/dist/gradient.bundle.js"></script>

        <title>Backend</title>

        <link rel="icon" href="https://fav.farm/🔥" />
    </head>
    <body class="items-center justify-center">
        <canvas class="fixed h-screen w-screen" id="bg"></canvas>
            
        <div class="fixed flex h-screen items-center justify-center left-0 p-6 top-0 w-screen">
            <form class="bg-white drop-shadow-lg p-6 rounded-md max-w-xs w-full">
                Hello world
            </form>
        </div>

        <script>
            new Gradient(document.getElementById('bg'), {
                colors: [
                    '#3b82f6',
                    '#14b8a6',
                    '#fb7185',
                    '#f8fafc',
                ],
                seed: Math.random(),
            })
        </script>
    </body>
</html>
