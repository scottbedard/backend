<div class="backend-banner">
  @isset ($header)
    <header>
      @isset ($icon)
        <x-backend::icon :name="$icon" size="24" />
      @endisset

      {{ $header }}
    </header>
  @endisset

  <div>{{ $slot }}</div>
</div>
