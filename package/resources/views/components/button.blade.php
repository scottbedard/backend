<button {{
  $attributes->class([
    'backend-btn',
    'backend-btn-danger' => $theme === 'danger',
    'backend-btn-default' => $theme === 'default',
    'backend-btn-primary' => $theme === 'primary',
  ])
}}>
  @if ($icon)
    <x-backend::icon :name="$icon" :size="18" />
  @endif

  {{ $slot }}
</button>