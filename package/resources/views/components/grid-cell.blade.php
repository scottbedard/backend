<div
  data-backend-grid-cell="{{ \Bedard\Backend\Classes\Breakpoint::json($span) }}"
  {{ $attributes->merge() }}>
  {{ $slot }}
</div>
