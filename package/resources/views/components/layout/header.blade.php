<header>
    <x-backend::margin
        class="flex h-16 items-center justify-between"
        padded-x>
        <div>
            <a
                class="flex font-bold gap-3 items-center"
                href="{{ route('backend.index') }}">
                <x-backend::icon name="code" />

                Site name
            </a>
        </div>

        <button data-toggle-dark-mode="{{ route('backend.settings.toggle') }}">
            <x-backend::icon class="dark:hidden" name="sun" />

            <x-backend::icon class="hidden dark:block" name="moon" />
        </button>
    </x-backend::layout.margin>
</header>