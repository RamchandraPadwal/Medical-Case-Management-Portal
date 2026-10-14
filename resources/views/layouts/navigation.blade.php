<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-sm border-b border-slate-200/80 sticky top-0 z-40 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left: Brand & Nav Links -->
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="shrink-0 focus:outline-none">
                    <x-application-logo />
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-teal-50 text-teal-800 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('cases.index') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('cases.*') ? 'bg-teal-50 text-teal-800 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        Cases
                    </a>
                </div>
            </div>

            <!-- Right: Role & User Menu -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @if (Auth::user()->isAdmin())
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-teal-50 text-teal-700 ring-1 ring-teal-600/20">
                        Admin
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-600">
                        Viewer
                    </span>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-lg text-slate-700 hover:bg-slate-50 focus:outline-none transition">
                            <span class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-slate-100 text-xs text-slate-500">
                            Signed in as <span class="font-medium text-slate-700">{{ Auth::user()->email }}</span>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-4 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-teal-50 text-teal-800 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
            Dashboard
        </a>
        <a href="{{ route('cases.index') }}"
           class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('cases.*') ? 'bg-teal-50 text-teal-800 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
            Cases
        </a>

        <div class="pt-3 border-t border-slate-100 mt-2">
            <div class="flex items-center justify-between px-3 py-1">
                <div>
                    <div class="font-semibold text-sm text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-400">{{ Auth::user()->email }}</div>
                </div>
                <span class="px-2 py-0.5 rounded text-xs font-medium {{ Auth::user()->isAdmin() ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ Auth::user()->role }}
                </span>
            </div>
            <div class="mt-2 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-1.5 text-sm text-slate-600 hover:bg-slate-50 rounded-lg">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-1.5 text-sm text-rose-600 hover:bg-rose-50 rounded-lg">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>
