<a
    class="inline-flex font-bold gap-x-2 items-center text-sm tracking-wide unstyled text-gray-700 hover:text-black"
    href="{{ $href }}">
    @if ($iconLeft)
        <x-backend::icon size="16" :name="$iconLeft"></x-backend::icon>
    @endif

    {{ $text }}

    @if ($iconRight)
        <x-backend::icon size="16" :name="$iconRight"></x-backend::icon>
    @endif
</a>