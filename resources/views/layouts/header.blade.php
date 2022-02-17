<nav class="bg-white shadow-sm">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <a href="{{ route('admin.index') }}" class="flex-shrink-0 flex items-center">
                    <img class="block lg:hidden h-6 w-auto" src="{{ asset(config('navigation._logo.url')) }}" alt="Logo">
                    <img class="hidden lg:block h-6 w-auto" src="{{ asset(config('navigation._logo.url')) }}" alt="Logo">
                </a>

                <div class="hidden lg:-my-px lg:ml-16 lg:flex lg:space-x-6">
                    @include('voiler::layouts.navigation.pages')
                </div>
            </div>

            <div class="hidden lg:ml-6 lg:flex lg:items-center">
                @include('voiler::layouts.sidebar.profile')
            </div>

            <div class="-mr-2 flex items-center lg:hidden">
                <button id="mobile-menu-toggle" type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <x-heroicon-o-menu class="block h-6 w-6" />
                    <x-heroicon-o-x class="hidden block h-6 w-6" />
                </button>
            </div>
        </div>
    </div>

    <div class="lg:hidden hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            @include('voiler::layouts.navigation.mobile-pages')
        </div>

        <div class="pt-4 pb-3 border-t border-gray-200">
            @include('voiler::layouts.navigation.mobile-profile')
        </div>
    </div>
</nav>
<form class="hidden" id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>