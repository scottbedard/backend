<div class="backend-banner">
  @isset ($header)
    <div>
      @isset ($icon)
        <x-backend::icon :name="$icon" size="24" />
      @endisset

      {{ $header }}
    </div>
  @endisset

  <p>
    {{ $slot }}
  </p>
</div>
