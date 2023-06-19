@php
    $tag = isset($href) ? 'a' : 'button';
@endphp

<{{ $tag }}
  {{ $attributes->class([
    'bg-gray-300 text-gray-900 hover:bg-gray-200 hover:text-black' => !isset($theme),
    'bg-red-500 text-white hover:bg-red-400 hover:text-white' => isset($theme) && $theme === 'primary',
    'flex font-bold h-12 gap-x-3 items-center justify-center gap-x-1 px-6 rounded-md tracking-wide'
  ]) }}
  @isset ($href)
    href="{{ $href }}"
  @endisset
  @isset ($type)
    type="{{ $type }}"
  @endisset>
  @isset ($iconLeft)
    <x-backend::icon :name="$iconLeft" size="20" />
  @endisset

  {{ $slot }}

  @isset ($iconRight)
    <x-backend::icon :name="$iconRight" size="20" />
  @endisset
</{{ $tag }}>