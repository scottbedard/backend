@props([
    'padded' => false,
])

<template x-teleport="body">
    <div
        {{
            $attributes->class([
                'bg-gray-900/60 bottom-0 items-center flex fixed justify-center left-0 p-6 right-0 top-0',
            ])->merge()
        }}
        @click="$dispatch('dismiss')">
        <div
            x-ref="body"
            class="bg-gray-50 overflow-hidden rounded-lg shadow-lg max-w-xl text-black w-full {{ $padded ? 'p-6' : '' }}"
            @click.stop>
            {{ $slot }}
        </div>
    </div>
</template>
