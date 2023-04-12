<x-layout>
  <div class="gap-6 grid max-w-md w-full">
    <h1 class="flex font-bold gap-3 items-center justify-center text-center text-xl">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
      
      <span>Welcome back</span>
    </h1>

    <x-card>
      <form
        action="{{ route('logout') }}"
        class="gap-6 grid"
        method="post">
        @csrf

        <div class="text-center">
          You're logged in as {{ $user->email }}
        </div>

        <div class="flex flex-wrap gap-6 justify-between">
          <a
            class="bg-gray-300 flex font-bold h-12 items-center justify-center px-3 rounded-md text-gray-600 transition-colors tracking-wide whitespace-nowrap w-full hover:bg-gray-200 hover:text-black sm:flex-1"
            href="{{ route('backend._root.index') }}">
            &larr; Backend
          </a>

          <a
            class="bg-red-500 flex font-bold h-12 items-center justify-center px-3 rounded-md text-white transition-colors tracking-wide whitespace-nowrap w-full hover:bg-red-400 sm:flex-1"
            href="{{ route('logout') }}">
            Log out &rarr;
          </a>
        </div>
      </form>
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
