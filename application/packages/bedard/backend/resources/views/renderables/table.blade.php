@php
    $query = request()->query()
@endphp

<div
    x-data="table({{ count($data['rows']) }})"
    x-modelable="modelable"
    x-model="checked"
    class="text-sm"
    data-table>
    <div class="table w-full">
        <div
            class="font-bold table-header-group tracking-wide"
            data-table-header>
            <div class="h-12 table-row">
                @if ($selectable)
                    <div
                        class="align-middle border-y border-gray-300 cursor-pointer pl-6 pr-3 relative table-cell text-right w-px dark:border-gray-800"
                        @click.stop.prevent="all = !all">
                        <div x-bind:class="all ? 'absolute bg-primary-400 left-0 top-0 h-full w-[3px] dark:bg-primary-600' : 'hidden'"></div>

                        <x-backend::checkbox x-model="all" />
                    </div>
                @endif

                @foreach ($columns as $column)
                    @php
                        $order = $column->sortOrder()
                    @endphp
                    
                    <a
                        @class([
                            'align-middle border-y border-gray-300 table-cell px-3 first:pl-6 last:pr-6 dark:border-gray-800' => true,
                            'cursor-pointer' => $column->sortable,
                            'unstyled' => !$column->sortable,
                        ])
                        @if ($column->sortable)
                            href="{{ $column->href() }}"
                        @endif
                        @if ($order === 1 || $order === -1)
                            data-table-sorted="{{ $order }}"
                        @endif
                        data-table-header="{{ $column->id }}">
                        <div
                            @class([
                                'flex items-center gap-1' => true,
                                'justify-center' => $column->align === 'center',
                                'justify-end' => $column->align === 'right',
                            ])>
                            <span>{{ $column->header }}</span>

                            @if ($order === 1)
                                <x-backend::icon
                                    class="text-primary-500"
                                    name="chevron-up" size="16"
                                    stroke-width="3.5" />
                            @elseif ($order === -1)
                                <x-backend::icon
                                    class="text-primary-500"
                                    name="chevron-down" size="16"
                                    stroke-width="3.5" />
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        @php
            $paginator = $data['rows']
        @endphp

        <div
            class="table-row-group"
            data-table-body>
            @foreach ($paginator as $row)
                <a
                    class="h-12 table-row unstyled odd:bg-gray-100 hover:bg-primary-100 dark:odd:bg-gray-500/30 dark:hover:bg-primary-500/20 dark:hover:bg-opacity-30"
                    href="{{ $to($row) }}"
                    data-table-row="{{ $loop->index }}">
                    @if ($selectable)
                        <div
                            class="align-middle cursor-pointer table-cell text-right pl-6 pr-3 relative w-px"
                            @click.stop.prevent="rows[{{ $loop->index }}] = !rows[{{ $loop->index }}]">
                            <div x-bind:class="rows[{{ $loop->index }}] ? 'absolute bg-primary-400 left-0 top-0 h-full w-[3px] dark:bg-primary-600' : 'hidden'"></div>

                            <x-backend::checkbox x-model="rows[{{ $loop->index }}]" />
                        </div>
                    @endif

                    @foreach ($columns as $column)
                        <div
                            @class([
                                'align-middle table-cell px-3 first:pl-6 last:pr-6' => true,
                                'text-left' => $column->align === 'left',
                                'text-center' => $column->align === 'center',
                                'text-right' => $column->align === 'right',
                            ])
                            data-table-column="{{ $column->id }}">
                            <x-backend::renderable
                                :content="$column"
                                :data="$row" />
                        </div>
                    @endforeach
                </a>
            @endforeach
        </div>
    </div>

    <div class="flex flex-wrap gap-x-6 gap-y-1 items-center justify-center py-2 px-6 lg:justify-end">
        <div class="text-gray-400">
            Displaying rows {{ $paginator->firstItem() }}&nbsp;-&nbsp;{{ $paginator->lastItem() }} of {{ $paginator->total() }}
        </div>

        <div class="flex justify-center w-full lg:w-auto">
            <div class="flex gap-3 items-center">
                <a
                    @class([
                        'cursor-arrow text-gray-400 unstyled' => $currentPage < 2,    
                    ])
                    @if ($currentPage < 2)
                        disabled
                    @else
                        href="{{ $firstPageHref }}"
                    @endif
                    data-first-page>
                        <x-backend::icon name="chevrons-left" size="16" />
                </a>

                <a
                    @class([
                        'cursor-arrow text-gray-400 unstyled' => $currentPage < 2,    
                    ])
                    @if ($currentPage < 2)
                        disabled
                    @else
                        href="{{ $prevPageHref }}"
                    @endif
                    data-prev-page>
                    <x-backend::icon name="chevron-left" size="16" />
                </a>

                <div class="group relative">
                    <select
                        class="appearance-none bg-transparent cursor-pointer outline-none pr-4 hover:text-primary-500 dark:text-auto"
                        @change="window.location = '{{ route('backend.resources.show', array_merge(request()->query(), ['id' => $data['resource']::$id, 'page' => '_page_'])) }}'.replace('_page_', $event.target.value)">
                        @for ($i = 1; $i <= $lastPage; $i++)
                            <option value="{{ $i }}" {{ $i === $currentPage ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>

                    <x-backend::icon
                        class="absolute right-0 top-1/2 pointer-events-none transform -translate-y-1/2 group-hover:text-primary-500"
                        name="chevron-down"
                        size="16" />
                </div>

                <a
                    href="{{ $nextPageHref }}"
                    data-next-page>
                    <x-backend::icon name="chevron-right" size="14" />
                </a>

                <a
                    href="{{ $lastPageHref }}"
                    data-last-page>
                    <x-backend::icon name="chevrons-right" size="16" />
                </a>
            </div>
        </div>
    </div>
</div>
