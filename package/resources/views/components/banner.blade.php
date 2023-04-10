<div class="border-2 border-gray-300 p-3 rounded-md">
  @isset ($header)
    <h1 class="flex font-bold gap-x-2 items-center tracking-wide">
      @isset ($icon)
        <x-backend::icon name="alert-triangle" size="24" />
      @endisset

      {{ $header }}
    </h1>
  @endisset

  <p class="mt-1 text-gray-800 sm:ml-[24px] sm:mt-0 sm:pl-2">
    {{ $slot }}
  </p>
</div>
