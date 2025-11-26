<div class="font-[HammersmithOne-Regular] bg-stone-900 text-white sticky top-0 z-50 w-full">
    <div class="flex justify-between items-center p-4 xl:w-[80%] mx-auto lg:w-full">
        <div class="flex gap-3 items-end">
            <a href="{{ route('member.history') }}" class="text-3xl font-bold max-lg:text-2xl">Cho's Studio</a>
            <p class="text-xl max-lg:text-lg max-m:text-base">MEMBER</p>
        </div>

        <div class="flex gap-5 items-center">
            <!-- Desktop nav -->
            <nav class="hidden md:block text-xl max-xl:text-lg font-bold">
                <ul class="flex gap-8 items-center">
                    {{-- <li><a href="{{ route('member.commmission') }}" class="hover:underline underline-offset-1 decoration-2 {{ request()->routeIs('member.commission') ? 'text-(--color-pastel-turqoise)' : '' }}">Commission</a></li> --}}
                    <li><a href="{{ route('member.commission_type') }}"
                            class="hover:underline underline-offset-1 decoration-2">Commission</a></li>
                    <li><a href="{{ route('member.history') }}"
                            class="hover:underline underline-offset-1 decoration-2 {{ request()->routeIs('member.history') ? 'text-(--color-pastel-turqoise)' : '' }}">History</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="py-2 px-4 rounded bg-(--status-danger) text-white text-2xl max-xl:text-base font-bold hover:scale-105 transition-transform duration-300">LOGOUT</button>
                        </form>
                    </li>
                </ul>

            </nav>
        </div>

        <!-- Mobile hamburger (Flowbite drawer trigger) -->
        <div class="md:hidden">
            <button data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation"
                aria-controls="drawer-navigation" aria-label="Open navigation"
                class="p-2 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                <!-- simple hamburger icon -->
                <svg id="hamburgerIcon" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Flowbite Drawer (mobile sidebar) -->
    <div id="drawer-navigation"
        class="fixed top-0 left-0 z-50 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-stone-900 text-white w-64"
        tabindex="-1" aria-labelledby="drawer-navigation-label">
        <div class="flex items-center justify-between">
            <div id="drawer-navigation-label" class="text-2xl font-bold">Cho's Studio</div>
            <button data-drawer-hide="drawer-navigation" aria-label="Close navigation"
                class="p-2 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="mt-4 p-4 text-lg">
            <ul class="flex flex-col gap-4">
                <li><a href="{}"
                        class="block {{ request()->routeIs('member.commisions') ? 'text-yellow-400 font-bold' : '' }}">Commisions</a>
                </li>
                <li><a href="{{ route('member.history') }}"
                        class="block {{ request()->routeIs('member.history') ? 'text-yellow-400 font-bold' : '' }}">History</a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left py-2 px-3 rounded bg-[var(--status-danger)] text-white">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Lighten Flowbite backdrop (Flowbite will create an element with [data-drawer-backdrop]) -->
    <style>
        /* Make drawer backdrop lighter */
        [data-drawer-backdrop] {
            background-color: rgba(0, 0, 0, 0.3) !important;
        }
    </style>

    <!-- Old manual script removed - Flowbite handles drawer interactions now -->
</div>
