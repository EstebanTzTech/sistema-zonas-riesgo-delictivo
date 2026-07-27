<nav x-data="{ open: false }" class="bg-[#4B5320] border border-white text-white rounded-md"> 
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- LOGO -->
            <div class="shrink-0 flex items-center">
                <a href="/">
                    <img src="{{ asset('imagenes/logo1.png') }}" alt="Logo Sistema" style="max-width: 85px; height: auto;">
                </a>
            </div>

            <!-- NAVIGATION LINKS -->
            <div class="hidden sm:flex space-x-8">
                @php
                    $tabs = [
                        ['route' => 'dashboard', 'label' => 'MODULO OFICIAL'],
                        ['route' => 'mapa.usuario', 'label' => 'MAPA DELITOS'],
                        ['route' => 'gestor.delitos', 'label' => 'GESTOR DELITOS'],
                        ['route' => 'denuncia.lista', 'label' => 'GESTOR DENUNCIAS'],
                    ];
                @endphp

                @foreach ($tabs as $tab)
                    <x-nav-link 
                        :href="route($tab['route'])" 
                        :active="request()->routeIs($tab['route'])" 
                        class="relative font-semibold uppercase px-4 py-2 transition duration-300 ease-in-out group">
                        <span class="transition-colors duration-300 {{ request()->routeIs($tab['route']) ? 'text-yellow-400' : 'text-white group-hover:text-yellow-400' }}">
                            {{ __($tab['label']) }}
                        </span>
                        @if(request()->routeIs($tab['route']))
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 !bg-yellow-400 rounded-full"></div>
                        @endif
                    </x-nav-link>
                @endforeach
            </div>

            <!-- PERFIL -->
            <div class="hidden sm:flex sm:items-center ms-auto">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="inline-flex items-center px-3 py-2 border border-[#4B5320] text-sm leading-4 font-medium rounded-md text-white bg-[#4B5320] hover:bg-[#3d431a] transition">
                <div>{{ Auth::user()->name }}</div>
                <div class="ms-1">
                    <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')" class="text-gray-800">
                {{ __('Perfil') }}
            </x-dropdown-link>

            {{-- botón: Registrar Usuario --}}
            <x-dropdown-link :href="route('register')" class="text-green-700 hover:text-green-800">
                {{ __('Registrar Usuario') }}
            </x-dropdown-link>

            {{-- botón: Historial de Delitos --}}
            <x-dropdown-link :href="url('/historial-delitos')" class="text-blue-700 hover:text-blue-800">
                {{ __('Historial de Modificación') }}
            </x-dropdown-link>
            {{-- botón: Gestor de Usuarios --}}
            <x-dropdown-link :href="route('gestor.usuarios')" class="text-purple-700 hover:text-purple-800">
                {{ __('Gestor de Usuarios') }}
            </x-dropdown-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();"
                    class="text-red-600 hover:text-red-700">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>

            <!-- HAMBURGER (para móvil) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-yellow-300 hover:bg-[#3d431a] focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MENU RESPONSIVE -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#4B5320] text-white">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($tabs as $tab)
                <x-responsive-nav-link 
                    :href="route($tab['route'])" 
                    :active="request()->routeIs($tab['route'])" 
                    class="pl-4 font-semibold border-l-4"
                    :class="request()->routeIs($tab['route']) ? 'text-yellow-400 border-yellow-400' : 'text-white border-transparent hover:border-yellow-400'">
                    {{ __($tab['label']) }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <div class="pt-4 pb-1 border-t border-green-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-yellow-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:text-yellow-300">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                {{-- Registrar Usuario en versión móvil --}}
                <x-responsive-nav-link :href="route('register')" class="text-green-300 hover:text-green-400">
                    {{ __('Registrar Usuario') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-red-400 hover:text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>



