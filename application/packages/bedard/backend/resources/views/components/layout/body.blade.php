<body {{ $attributes->class([]) }}>
    {{ $slot }}

    @if (config('app.env') === 'local' && !env('LARAVEL_DUSK'))
        <script type="module" src="http://localhost:3000/@vite/client"></script>
        <script type="module" src="http://localhost:3000/resources/scripts/main.ts"></script>
    @elseif ($manifest)
        <script type="module" src="/vendor/backend/dist/{{ $manifest['resources/scripts/main.ts']['file'] }}"></script>
    @else
        <script>console.error('Manifest not found, please run the following:\n\nphp artisan vendor:publish --tag backend')</script>
    @endif

    <script src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js" defer></script>
</body>
