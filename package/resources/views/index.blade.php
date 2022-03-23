<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Backend</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&family=Source+Code+Pro&display=swap" rel="stylesheet">

        @unless ($local)
            @foreach ($manifest['client/main.ts']['css'] as $stylesheet)
                <link href="/vendor/backend/dist/{{ $stylesheet }}" rel="stylesheet">
            @endforeach
        @endunless
    </head>
    <body class="bg-white duration-300 text:gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors">
        <div id="backend"></div>

        <script>
            // window.context = {!! $context !!}
        </script>

        @if ($local)
            <script type="module" src="http://localhost:3000/@vite/client"></script>
            <script type="module" src="http://localhost:3000/client/main.ts"></script>
        @else
            <script type="module" src="/vendor/backend/dist/{{ $manifest['client/main.ts']['file'] }}"></script>
        @endif
    </body>
</html>
