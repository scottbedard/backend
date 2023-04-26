<div
  data-backend-script="grid"
  {{ $attributes->merge([
    'class' => $padded ? 'gap-6 grid' : 'grid',
    'style' => 'grid-template-columns: repeat(' . $cols . ', minmax(0, 1fr));',
  ]) }}>
  {{ $slot }}
</div>
