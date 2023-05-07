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
    <script>
      window.context = {}
    </script>

    <header class="bg-gray-900 flex gap-6 p-6 text-gray-100">
      <nav class="flex-1 flex gap-x-10 items-center">
        @foreach ($nav as $button)
          <a
            class="flex font-bold gap-x-2 items-center tracking-wide text-gray-100/60 hover:text-white"
            href="{{ $button->href() }}">
            @if ($button->get('icon'))
              <x-backend::icon :name="$button->get('icon')" size="20" />
            @endif

            {{ $button->get('label') }}
          </a>
        @endforeach
      </nav>

      <div>
        <a
          class="text-gray-100/80 hover:text-white"
          href="{{ $logout }}"
          data-cy="logout">
          <x-backend::icon name="log-out" size="20" />
        </a>
      </div>
    </header>

    <div class="flex flex-1">
      @if (count($subnav) > 0)
        <aside class="bg-gray-100 flex-col gap-6 hidden items-center p-6 w-20 md:flex">
          @foreach ($subnav as $link)
            <a
              class="aspect-square flex flex-col gap-1 items-center justify-center text-center"
              href="{{ $link['href'] }}">
              <x-backend::icon
                :name="$link['icon']"
                size="24" />

              <div class="px-2 text-xs">{{ $link['label'] }}</div>
            </a>
          @endforeach
        </aside>
      @endif

      <main {{ $attributes->merge(['class' => $padded ? 'flex-1 p-6' : 'flex-1']) }}>
        {{ $slot }}
      </main>
    </div>

    @if ($dev)
      <script type="module" src="http://localhost:3000/@@vite/client"></script>
      <script type="module" src="http://localhost:3000/client/main.ts"></script>
    @elseif ($scripts)
      <script type="module" src="{{ asset('vendor/backend/' . $manifest->script('client/main.ts')) }}"></script>
    @endif
  </body>
</html>
