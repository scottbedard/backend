<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', '') }} backend</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=quicksand:400" rel="stylesheet" />

    @foreach ($manifest['client/main.ts']['css'] as $stylesheet)
      <link href="/vendor/backend/dist/{{ $stylesheet }}" rel="stylesheet">
    @endforeach
  </head>
  <body>
    <div id="app"></div>

    @if (env('BACKEND_DEV'))
      <script type="module" src="http://localhost:3000/@@vite/client"></script>
      <script type="module" src="http://localhost:3000/client/main.ts"></script>
    @elseif ($manifest)
      <script type="module" src="/vendor/backend/dist/{{ $manifest['client/main.ts']['file'] }}"></script>
    @endif
  </body>
</html>
