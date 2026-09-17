<nav x-data="{ open: false }" class="bg-indigo-950 border-b border-indigo-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white">
                    <svg class="h-8 w-8 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 3c.6 3.5-1.3 6.6-4.5 6.6-.6 0-1.2-.1-1.7-.3C7.8 13 10.9 16 14.5 16c4.6 0 7.5-3 7.5-8.2V3h-9z"/>
                        <path d="M4 8.5C4 14.8 9.5 19 16 19.5c1.2 0 2.4-.1 3.5-.4-1 2.8-3.6 4.9-6.8 4.9C7.4 24 3 19.6 3 14.2c0-3.2 2.1-5.8 4.9-6.8-.1.7-.1 1.4-.1 1.1 0 2 1.3 3.7 3.2 4.5a6.5 6.5 0 0 1-2.4-4.3c0-.3 0-.7 0-1V8.5z" opacity=".55"/>
                    </svg>
                    <span class="text-lg font-bold tracking-tight">{{ config('app.name', 'FitNova Gym') }}</span>
                </a>

                <div class="hidden space-x-1 lg:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="!text-white hover:!bg-indigo-900">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (auth()->user()->esAdmin())
                        <x-nav-link :href="route('socios.index')" :active="request()->routeIs('socios.*')" class="!text-white hover:!bg-indigo-900">
                            Socios
                        </x-nav-link>
                        <x-nav-link :href="route('planes.index')" :active="request()->routeIs('planes.*')" class="!text-white hover:!bg-indigo-900">
                            Planes
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('membresias.index')" :active="request()->routeIs('membresias.*')" class="!text-white hover:!bg-indigo-900">
                        Membresías
                    </x-nav-link>

                    <x-nav-link :href="route('pagos.index')" :active="request()->routeIs('pagos.*')" class="!text-white hover:!bg-indigo-900">
                        Pagos
                    </x-nav-link>

                    <x-nav-link :href="route('rutinas.index')" :active="request()->routeIs('rutinas.*')" class="!text-white hover:!bg-indigo-900">
                        Rutinas
                    </x-nav-link>

                    <x-nav-link :href="route('clases.index')" :active="request()->routeIs('clases.*')" class="!text-white hover:!bg-indigo-900">
                        Clases
                    </x-nav-link>

                    @if (! auth()->user()->esSocio())
                        <x-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')" class="!text-white hover:!bg-indigo-900">
                            Reportes
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-900 hover:bg-indigo-800 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ auth()->user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                            {{ ucfirst(auth()->user()->role) }}
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white hover:bg-indigo-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-indigo-950">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (auth()->user()->esAdmin())
                <x-responsive-nav-link :href="route('socios.index')" :active="request()->routeIs('socios.*')">Socios</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('planes.index')" :active="request()->routeIs('planes.*')">Planes</x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('membresias.index')" :active="request()->routeIs('membresias.*')">Membresías</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pagos.index')" :active="request()->routeIs('pagos.*')">Pagos</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('rutinas.index')" :active="request()->routeIs('rutinas.*')">Rutinas</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('clases.index')" :active="request()->routeIs('clases.*')">Clases</x-responsive-nav-link>

            @if (! auth()->user()->esSocio())
                <x-responsive-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')">Reportes</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-indigo-900">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ auth()->user()->name }}</div>
                <div class="font-medium text-sm text-indigo-300">{{ auth()->user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>