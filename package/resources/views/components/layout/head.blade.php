<head>
    <title>Backend</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&family=Source+Code+Pro&display=swap" rel="stylesheet">

    @unless (env('APP_ENV') === 'local')
        @foreach ($manifest['src/main.ts']['css'] as $stylesheet)
            <link href="/vendor/backend/dist/{{ $stylesheet }}" rel="stylesheet">
        @endforeach
    @endunless
</head>
