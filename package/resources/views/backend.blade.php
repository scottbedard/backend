<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', '') }} backend</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=quicksand:400,600" rel="stylesheet" />

    {{-- @if (!$dev && $styles)
      @foreach ($styles as $file)
        <link href="{{ asset('vendor/backend/' . $file) }}" rel="stylesheet">
      @endforeach
    @endif --}}
  </head>
  <body>
    <h1>Hello from the backend</h1>

    {{-- @if ($dev)
      <script type="module" src="http://localhost:3000/@@vite/client"></script>
      <script type="module" src="http://localhost:3000/client/main.ts"></script>
    @elseif ($scripts)
      <script type="module" src="{{ asset('vendor/backend/' . $manifest->script('client/main.ts')) }}"></script>
    @endif --}}
  </body>
</html>
