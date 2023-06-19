<x-layout>
  <div class="gap-6 grid max-w-md w-full">
    <h1 class="flex font-bold gap-3 items-center justify-center text-center text-xl">
      <x-backend::icon name="file-question" size="26" />

      <span data-404>Page not found</span>
    </h1>

    <x-card>
      <div class="gap-6 grid">
        <p>
          This route either does not exist, or the current user is not authorized. Try using
          <a class="font-semibold inline-block text-sm text-red-500 tracking-wide hover:text-red-400" href="/login?user=super-admin">super-admin@example.com</a> to see if it's a permission issue.
        </p>

        <div class="flex flex-wrap gap-6 justify-between">
          @auth
            <x-button
              class="flex-1"
              icon-left="log-out">
              Log out
            </x-button>

            <x-button
              class="flex-1"
              icon-left="key-square"
              href="{{ route('backend.controller.route') }}"
              theme="primary">
              Backend
            </x-button>

          @endauth

          @guest
            <x-button
              theme="primary">
              Login
            </x-button>
            <a
              class="bg-gray-300 flex font-bold gap-x-1 h-12 items-center justify-center px-3 rounded-md text-gray-600 transition-colors tracking-wide whitespace-nowrap w-full hover:bg-gray-200 hover:text-black sm:flex-1"
              href="{{ route('login') }}">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
              
              Login
            </a>
          @endguest
        </div>
      </div>
    </x-card>

    <div class="flex flex-wrap gap-x-12 gap-y-2 justify-between gap-3 text-xs text-gray-600">
      <a
        class="flex gap-1 items-center justify-center tracking-wide hover:text-red-500 w-full sm:w-auto"
        href="https://github.com/scottbedard/backend">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path><path d="M9 18c-4.51 2-5-2-7-2"></path></svg>
        
        <span>scottbedard/backend</span>
      </a>

      <a
        class="flex gap-1 items-center justify-center tracking-wide hover:text-red-500 w-full sm:w-auto"
        href="https://laravel.com/docs/10.x">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
      </a>
    </div>
  </div>
</x-layout>
