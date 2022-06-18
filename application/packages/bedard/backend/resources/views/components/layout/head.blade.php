<head>
    <title>Backend</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&family=Source+Code+Pro&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (config('app.env') !== 'local' && $manifest)
        @foreach ($manifest['resources/scripts/main.ts']['css'] as $stylesheet)
            <link href="/vendor/backend/dist/{{ $stylesheet }}" rel="stylesheet">
        @endforeach
    @endif
</head>
