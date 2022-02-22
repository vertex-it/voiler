<!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
<div class="fixed inset-0 flex z-40" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
    <div class="relative flex-1 flex flex-col max-w-xs w-full px-8 py-6 bg-white">
        <div class="absolute top-0 right-0 -mr-12 pt-2">
            <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white mobile-menu-close">
                <span class="sr-only">Close sidebar</span>
                <!-- Heroicon name: outline/x -->
                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex-shrink-0 flex items-center">
            <img class="h-10 w-auto" src="{{ asset(config('navigation._logo.url')) }}" alt="Workflow">
        </div>
        <div class="mt-5 flex-1 h-0 overflow-y-auto">
            <nav class="flex-1 pb-4">
                @include('voiler::layouts.navigation.pages')
            </nav>
        </div>
        <div class="py-4 -mx-6 px-6 border-t border-gray-200">
            @include('voiler::layouts.navigation.mobile-profile')
        </div>
    </div>

    <div class="flex-shrink-0 w-14" aria-hidden="true">
        <!-- Dummy element to force sidebar to shrink to fit close icon -->
    </div>
</div>
