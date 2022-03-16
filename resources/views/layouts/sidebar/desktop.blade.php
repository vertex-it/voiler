<div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
    <div class="flex flex-col flex-grow px-8 py-6 bg-white overflow-y-auto shadow">
        <div class="flex items-center flex-shrink-0">
            <img class="h-10 w-auto" src="{{ asset(config('navigation._logo.url')) }}" alt="Workflow">
        </div>
        <div class="mt-5 flex-grow flex flex-col">
            <nav class="flex-1 pb-4">
                @include('voiler::layouts.navigation.pages')
            </nav>
        </div>
    </div>
</div>
