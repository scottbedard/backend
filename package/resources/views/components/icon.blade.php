<span {{ $attributes->merge(['style' => "width: {$size}px"]) }}>
  <i
    data-lucide="{{ $name }}"
    height="{{ $size }}"
    width="{{ $size }}"
    {{ $attributes }}
  ></i>
</span>
