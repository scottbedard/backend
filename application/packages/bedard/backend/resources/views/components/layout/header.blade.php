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

        <div class="flex items-center gap-6 text-sm">
            <div>
                {{ auth()->user()->email }}
            </div>

            <a
                x-data="darkMode"
                x-bind:title="`Toggle ${dark ? 'light' : 'dark'} mode`"
                class="cursor-pointer"
                data-endpoint="hello"
                @click.prevent="toggle">
                <template x-if="dark">
                    <x-backend::icon name="moon" size="20" />
                </template>

                <template x-if="!dark">
                    <x-backend::icon name="sun" size="20" />
                </template>
            </a>

            @if (auth()->user()->can('super admin'))
                <a
                    data-admins-link
                    href="{{ route('backend.admins.index') }}"
                    title="Manage Administrators">
                    <x-backend::icon name="lock" size="20" />
                </a>
            @endif

            <a href="/logout" title="Log out">
                <x-backend::icon name="log-out" size="20" />
            </a>
        </div>
    </x-backend::layout.margin>
</header>