@if ($href)
  <a 
    href="{{ $href }}"
    {{
      $attributes->class([
        'backend-btn',
        'backend-btn-danger' => $theme === 'danger',
        'backend-btn-default' => $theme === 'default',
        'backend-btn-primary' => $theme === 'primary',
        'backend-btn-text' => $theme === 'text',
      ])
    }}>
    @if ($icon)
      <x-backend::icon :name="$icon" :size="18" />
    @endif

    {{ $slot }}
  </a>
@else
  <button {{
    $attributes->class([
      'backend-btn',
      'backend-btn-danger' => $theme === 'danger',
      'backend-btn-default' => $theme === 'default',
      'backend-btn-primary' => $theme === 'primary',
      'backend-btn-text' => $theme === 'text',
    ])
  }}>
    @if ($icon)
      <x-backend::icon :name="$icon" :size="18" />
    @endif

    {{ $slot }}
  </button>
@endif
