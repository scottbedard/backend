@php($tag = $href ? 'a' : 'button')

<{{ $tag }}
  @if ($confirmation)
    data-backend-confirmation="{{ json_encode($confirmation->toArray()) }}"
  @endif
  @if ($href)
    href="{{ $href }}"
  @endif
  @if($tag === 'button')
    type="{{ $type }}"
  @endif
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
</{{ $tag }}>
