<header>
    <x-backend::margin
        class="bg-gray-900 flex h-16 items-center justify-between text-white"
        padded-x>
        <div>
            <a
                class="flex font-bold gap-3 items-center"
                href="{{ route('backend.index') }}">
                <x-backend::icon name="code" />

                Site name
            </a>
        </div>

        <div class="flex gap-6">
            <a data-toggle-dark-mode="{{ route('backend.settings.toggle') }}" href="javascript:;">
                <x-backend::icon class="dark:hidden" name="sun" />

                <x-backend::icon class="hidden dark:block" name="moon" />
            </a>

            <a href="/logout">
                <x-backend::icon name="log-out" />
            </a>
        </div>

    </x-backend::layout.margin>
</header>