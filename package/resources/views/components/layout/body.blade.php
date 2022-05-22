<body class="dark:bg-gray-800 dark:text-white">
    {{ $slot }}

    {{-- toggle dark mode as soon as possible to avoid a flicker --}}
    <script>if(JSON.parse(window.localStorage.getItem('darkMode')))document.documentElement.classList.add('dark')</script>

    <script src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js" defer></script>

    @if (env('APP_ENV') === 'local')
        <script type="module" src="http://localhost:3000/@vite/client"></script>
        <script type="module" src="http://localhost:3000/resources/scripts/main.ts"></script>
    @elseif ($manifest)
        <script type="module" src="/vendor/backend/dist/{{ $manifest['resources/scripts/main.ts']['file'] }}"></script>
    @else
        <script>console.error('Manifest not found, please run the following:\n\nphp artisan vendor:publish --tag backend')</script>
    @endif
</body>
