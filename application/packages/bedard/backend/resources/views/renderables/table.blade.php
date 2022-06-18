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
                                    name="chevron-up"
                                    size="16"
                                    stroke-width="3" />
                            @elseif ($order === -1)
                                <x-backend::icon
                                    class="text-primary-500"
                                    name="chevron-down"
                                    size="16"
                                    stroke-width="3" />
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

    <div class="flex flex-wrap gap-x-4 gap-y-2 items-center justify-center py-4 px-6 text-sm lg:justify-end">
        <div class="tracking-wide">
            Displaying rows {{ $paginator->firstItem() }}&nbsp;-&nbsp;{{ $paginator->lastItem() }} of {{ $paginator->total() }}
        </div>

        <div class="flex justify-center w-full lg:w-auto">
            <div class="flex gap-1 h-6 items-center">
                <a
                    @class([
                        'aspect-square flex items-center h-full justify-center rounded' => true,
                        'hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-gray-800' => $currentPage >= 2,
                        'cursor-arrow text-gray-300 unstyled dark:text-gray-400' => $currentPage < 2, 
                    ])
                    @if ($currentPage <= 1)
                        disabled
                    @else
                        href="{{ $firstPageHref }}"
                        title="First page"
                    @endif
                    data-first-page>
                        <x-backend::icon
                            name="chevrons-left"
                            size="16"
                         />
                </a>

                <a
                    @class([
                        'aspect-square flex items-center h-full justify-center rounded' => true,
                        'hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-gray-800' => $currentPage >= 2,
                        'cursor-arrow text-gray-300 unstyled dark:text-gray-400' => $currentPage < 2,    
                    ])
                    @if ($currentPage <= 1)
                        disabled
                    @else
                        href="{{ $prevPageHref }}"
                        title="Previous page"
                    @endif
                    data-prev-page>
                    <x-backend::icon
                        name="chevron-left"
                        size="16"
                     />
                </a>

                <div class="flex items-center group h-full relative rounded hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-gray-800">
                    <select
                        class="appearance-none bg-transparent cursor-pointer font-bold outline-none text-center tracking-wide pl-2 pr-5 hover:text-primary-500 dark:text-auto"
                        title="Select page"
                        @change="window.location = '{{ route('backend.resources.show', array_merge(request()->query(), ['id' => $data['resource']::$id, 'page' => '_page_'])) }}'.replace('_page_', $event.target.value)">
                        @for ($i = 1; $i <= $lastPage; $i++)
                            <option value="{{ $i }}" {{ $i === $currentPage ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>

                    <x-backend::icon
                        class="absolute right-1 top-1/2 pointer-events-none transform -translate-y-1/2 group-hover:text-primary-500"
                        name="chevron-down"
                        size="14" />
                </div>

                <a
                @class([
                        'aspect-square flex items-center h-full justify-center rounded' => true,
                        'hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-gray-800' => $currentPage < $lastPage,
                        'cursor-arrow text-gray-300 unstyled dark:text-gray-400' => $currentPage >= $lastPage,    
                    ])
                    @if ($currentPage >= $lastPage)
                        disabled
                    @else
                        href="{{ $nextPageHref }}"
                        title="Next page"
                    @endif
                    data-next-page>
                    <x-backend::icon name="chevron-right" size="16" />
                </a>

                <a
                @class([
                        'aspect-square flex items-center h-full justify-center rounded' => true,
                        'hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-gray-800' => $currentPage < $lastPage,
                        'cursor-arrow text-gray-300 unstyled dark:text-gray-400' => $currentPage >= $lastPage,    
                    ])
                    @if ($currentPage >= $lastPage)
                        disabled
                    @else
                        href="{{ $lastPageHref }}"
                        title="Last page"
                    @endif
                    data-last-page>
                    <x-backend::icon name="chevrons-right" size="16" />
                </a>
            </div>
        </div>
    </div>
</div>
