<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', '') }} backend</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=source-code-pro:400|quicksand:400,600" rel="stylesheet" />

    @if (!$dev && $styles)
      @foreach ($styles as $file)
        <link href="{{ asset("vendor/backend/{$file}") }}" rel="stylesheet">
      @endforeach
    @endif
  </head>
  <body class="min-h-screen flex flex-col">
    <header class="bg-gray-900 flex gap-6 p-6 text-gray-100">
      <a class="flex gap-2 items-center text-gray-100/80 hover:text-white" href="{{ route('backend.index') }}">
        <x-backend::icon name="shield-check" />
        
        <span class="font-bold tracking-wider">bedard/backend</span>
      </a>

      <nav class="flex-1 flex justify-center items-center">
        @foreach ($nav as $button)
          <a class="flex font-bold gap-x-3 items-center tracking-wide text-gray-100/80 hover:text-white" href="{{ $button['href'] }}">
            <x-backend::icon :name="$button['icon']" size="20" />

            {{ $button['label'] }}
          </a>
        @endforeach
      </nav>

      <div>
        <a class="text-gray-100/80 hover:text-white" href="/">
          <x-backend::icon name="log-out" size="20" />
        </a>
      </div>
    </header>

    <div class="flex flex-1">
      <aside class="bg-primary-50 flex flex-col items-center p-6 w-20">
        ...
      </aside>

      <main class="flex-1">
        {{ $slot }}
      </main>
    </div>

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
