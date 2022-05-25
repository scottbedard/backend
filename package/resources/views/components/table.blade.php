@props([
    'data' => [],
    'schema' => [],
])

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
    <tbody>
        @foreach ($data as $row)
            <tr>
                @foreach ($schema as $column)
                    <td>{{ $column->render($row) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
