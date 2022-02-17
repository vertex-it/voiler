<!-- Static sidebar for desktop -->
<div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex flex-col flex-grow border-r border-gray-200 pt-5 bg-white overflow-y-auto">
        <div class="flex items-center flex-shrink-0 px-4">
            <img class="h-8 w-auto" src="{{ asset(config('navigation._logo.url')) }}" alt="Workflow">
        </div>
        <div class="mt-5 flex-grow flex flex-col">
            <nav class="flex-1 px-2 pb-4 space-y-1">
                @include('voiler::layouts.navigation.mobile-pages')

                {{--<!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->--}}
                {{--<a href="#" class="bg-gray-100 text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">--}}
                {{--    <!----}}
                {{--      Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"--}}
                {{--    -->--}}
                {{--    Dashboarddddddd--}}
                {{--</a>--}}

                {{--<a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">--}}
                {{--    Team--}}
                {{--</a>--}}

            </nav>
        </div>
    </div>
</div>