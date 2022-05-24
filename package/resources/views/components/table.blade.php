@props([
    'schema' => [],
])

<div>
    {{ json_encode($schema) }}
</div>

<table class="border border-primary-500 border-collapse">
    <thead>
        <tr>
            @foreach ($schema as $column)
                <th class="border border-black px-6 tracking-wide">
                    {{ $column->renderHeader() }}
                </th>
            @endforeach
        </tr>
    </thead>
</table>
