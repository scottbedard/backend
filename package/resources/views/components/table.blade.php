@props([
    'schema' => [],
])

<div>
    {{ json_encode($schema) }}
</div>

<table class="border border-primary-500">
    <thead>
        <tr>
            @foreach ($schema as $column)
                <th>{{ $column->header }}
            @endforeach
        </tr>
    </thead>
</table>
