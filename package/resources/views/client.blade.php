<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', '') }} backend</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=quicksand:400" rel="stylesheet" />

    @if (!$dev && $styles)
      @foreach ($styles as $file)
        <link href="{{ asset('vendor/backend/' . $file) }}" rel="stylesheet">
      @endforeach
    @endif
  </head>
  <body>
    <div
      data-view="{{ $view }}"
      id="app"
    ></div>

    <script>
      window.context = {};
      window.context.data = @json($data);
    </script>

    @if ($dev)
      <script type="module" src="http://localhost:3000/@@vite/client"></script>
      <script type="module" src="http://localhost:3000/client/main.ts"></script>
    @elseif ($scripts)
      @foreach ($scripts as $file)
        <script type="module" src="{{ asset('vendor/backend/' . $file) }}"></script>
      @endforeach
    @else
      <script src="https://cdn.tailwindcss.com"></script>
      <script>
        function copy() {
          navigator.clipboard.writeText('php artisan vendor:publish --tag=backend').then(
            () => console.log('✅ Copied command'),
            () => console.log('❌ Failed to copy command'),
          )
        }
      </script>

      <div class="h-screen flex items-center justify-center p-6 text-center w-full">
        <div class="flex flex-wrap gap-1 justify-center items-center">
          <div>Backend vendor files not found, try running</div>

          <button
            class="bg-gray-200 cursor-pointer font-mono text-sm p-1 relative rounded"
            onclick="copy()">
            php artisan vendor:publish --tag=backend
          </button>
        </div>
      </div>
    @endif
  </body>
</html>
