<span
    @class([
        'text-danger-500' => $danger,
        'text-primary-500' => $primary,
        'text-success-500' => $success,
    ])
    data-icon-column="{{ $icon }}"
    {{ !$danger && !$success && !primary ? 'data-icon-column-default' : null }}
    {{ $danger ? 'data-icon-column-danger' : null }}
    {{ $success ? 'data-icon-column-success' : null }}
    {{ $primary ? 'data-icon-column-primary' : null }}>
    <x-backend::icon :name="$icon" />
</span>
