<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', '') }} backend</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=source-code-pro:400|quicksand:400,500,600" rel="stylesheet" />

    @if (!$dev && $styles)
      @foreach ($styles as $file)
        <link href="{{ asset("vendor/backend/{$file}") }}" rel="stylesheet">
      @endforeach
    @endif
  </head>
  <body class="min-h-screen flex flex-col relative">
    <script>
      window.context = {}
    </script>

    <header class="bg-gray-900 flex gap-6 p-6 text-gray-100">
      <nav class="flex-1 flex gap-x-10 items-center">
        @foreach ($backend->nav as $item)
          @if ($item)
            <a
              class="flex font-bold gap-x-2 items-center tracking-wide text-gray-100/60 hover:text-white"
              data-nav-to="{{ $item->to }}"
              href="{{ $item->href }}">
              @if ($item->icon)
                <x-backend::icon :name="$item->icon" size="20" />
              @endif

              {{ $item->label }}
            </a>
          @endif
        @endforeach
      </nav>

      <div class="flex gap-3 items-center">
        <a
          class="font-semibold text-gray-100/80 text-sm tracking-wider">
          {{ $user->email }}
        </a>

        <a
          class="aspect-square flex h-8 items-center justify-center text-gray-100/80 hover:text-white"
          href="{{ config('backend.logout_href') }}"
          data-cy="logout">
          <x-backend::icon name="log-out" size="18" />
        </a>
      </div>
    </header>

    <div class="flex flex-1">
      {{-- whitespace is commented out for the :empty selector to work --}}
      <aside class="bg-gray-100 flex-col hidden items-center w-20 md:flex empty:hidden">{{--
    --}}@foreach ($backend->currentRoute->controller->subnav as $link)
          <a
            @class([
              'aspect-square flex flex-col gap-1 items-center justify-center p-1 text-center w-full hover:text-primary-500',
              'text-primary-500' => $link->isActive(),
            ])
            data-subnav-to="{{ $link->to }}"
            href="{{ $link->href }}">
            @if ($link->icon)
              <x-backend::icon :name="$link->icon" size="24" />
            @endif

            <div class="px-2 text-xs">{{ $link->label }}</div>
          </a>
        @endforeach{{--
  --}}</aside>

      <main {{ $attributes->merge(['class' => $padded ? 'flex-1 p-6' : 'flex-1']) }}>
        {{ $slot }}
      </main>
    </div>

    @if (session()->has('message'))
      @php($message = session('message'))
      @php($status = data_get($message, 'status'))
      <button
        class="absolute left-1/2 -translate-x-1/2 px-3 py-6 w-full md:w-auto"
        id="backend-flash-message">
        <div @class([
          'cursor-pointer flex gap-x-2 font-bold px-4 py-2 rounded-md shadow text-sm tracking-wide',
          'bg-success-500 text-white hover:bg-success-400' => $status === 'success',
          'bg-danger-500 text-white hover:bg-danger-400' => $status === 'error',
        ])>
          @if (session('message.icon'))
            <div>
              <x-backend::icon :name="session('message.icon')" size="20" />
            </div>
          @endif

          {{ data_get($message, 'text', '')}}
        </div>
      </button>
    @endif

    @if ($dev)
      <script type="module" src="http://localhost:3000/@@vite/client"></script>
      <script type="module" src="http://localhost:3000/client/main.ts"></script>
    @elseif ($scripts)
      <script type="module" src="{{ asset('vendor/backend/' . $manifest->script('client/main.ts')) }}"></script>
    @endif
  </body>
</html>
