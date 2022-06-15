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
        <canvas class="fixed h-screen w-screen pointer-events-none" id="bg"></canvas>
            
        <div class="fixed flex h-screen items-center justify-center left-0 p-6 top-0 w-screen">
            <form
                action="/auth"
                method="POST"
                class="bg-white drop-shadow-xl grid gap-6 p-6 rounded-md max-w-md w-full">
                @csrf

                <label>
                    <div class="font-bold mb-1 text-sm tracking-wider">Email address</div>

                    <input
                        autofocus
                        class="border border-slate-300 h-12 px-3 rounded-md w-full hover:border-blue-500"
                        name="email"
                        required
                        type="email"
                        value="admin@example.com" />
                </label>

                <label>
                    <div class="font-bold mb-1 text-sm tracking-wider">Password</div>

                    <input
                        class="border border-slate-300 h-12 px-3 rounded-md w-full hover:border-blue-500"
                        name="password"
                        required
                        type="password"
                        value="password" />
                </label>

                <div class="border-gray-500 flex justify-end">
                    <button class="bg-blue-500 font-semibold h-12 px-6 rounded-md text-white text-sm tracking-wider hover:bg-blue-400">
                        Log in
                    </button>
                </div>
            </form>
        </div>

        <script>
            new Gradient(document.getElementById('bg'), {
                colors: [
                    'f1f5f9',
                    'dbeafe',
                    'e0e7ff',
                    'ede9fe',
                ],
                seed: Math.random(),
            })
        </script>
    </body>
</html>
