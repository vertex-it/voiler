<header class="bg-white border-b border-gray-100">
    <div class="container mx-auto flex justify-between items-center">
        <a href="#">
            <img src="{{ asset('img/logo.svg') }}" class="h-6" alt="logo">
        </a>
        @include('voiler::layouts.navigation')
        <div class="flex items-center">
            <button class="p-1 rounded-full text-gray-600 hover:text-gray-700 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-offset-gray-500 focus:ring-white">
                <span class="sr-only">View notifications</span>
                <!-- Heroicon name: outline/bell -->
                <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                >
                    <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                    />
                </svg>
            </button>

            <!-- Profile dropdown -->
            <div class="ml-4 relative btn-click-dropdown">
                <div>
                    <button
                            type="button"
                            class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                            id="user-menu-button"
                            aria-expanded="false"
                            aria-haspopup="true"
                    >
                        <span class="sr-only">Open user menu</span>
                        <img
                            class="image h-8 w-8 rounded-full"
                            src="{{ asset('img/avatar.png') }}"
                            alt=""
                        >
                    </button>
                </div>
                <nav class="dropdown mt-6 hidden right-0">
                    <a href="#" class="item">
                        Profile
                    </a>
                    <a href="#" class="item" onclick="document.getElementById('logout-form').submit();">
                        Sign out
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

<style>
    .btn-open-dropdown:hover > .dropdown {
        display: flex;
    }
</style>

@once
    @push('scripts')
        <script>
            $('header').delegate('.btn-click-dropdown', 'click', function () {
                $(this).parent().find('.dropdown').first().toggleClass('hidden');
            })

            $('body').on('click',function(event){
                if (
                    ! $(event.target).is('.btn-click-dropdown') &&
                    ! $(event.target).is('.image') &&
                    ! $(event.target).is('.items-baseline') &&
                    ! $(event.target).is('.btn-open-dropdown')
                ) {
                    $(".dropdown").addClass("hidden");
                }
            });
        </script>
    @endpush
@endonce
