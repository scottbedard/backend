<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', '') }} backend</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=quicksand:400,600" rel="stylesheet" />

    @if (!$dev && $styles)
      @foreach ($styles as $file)
        <link href="{{ asset("vendor/backend/{$file}") }}" rel="stylesheet">
      @endforeach
    @endif
  </head>
  <body>
    <header class="bg-gray-900 flex justify-between p-6 text-gray-100">
      <a class="flex gap-2 items-center" href="{{ route('backend.index') }}">
        <x-backend::icon name="shield-check" />
        
        <span class="font-bold tracking-wider">bedard/backend</span>
      </a>
    </header>

    {{ $slot }}

    @if ($dev)
      <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
      <script type="module" src="http://localhost:3000/@@vite/client"></script>
      <script type="module" src="http://localhost:3000/client/main.ts"></script>
    @elseif ($scripts)
      <script src="https://unpkg.com/lucide@latest"></script>
      <script type="module" src="{{ asset('vendor/backend/' . $manifest->script('client/main.ts')) }}"></script>
    @endif

    <script>
      lucide.createIcons()
    </script>
  </body>
</html>
