<div class="flex items-center">
    <div class="flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
        </svg>
    </div>
    <div class="ml-3">
        <div class="text-sm font-medium text-gray-800">{{ Auth::user()->getTitle() }}</div>
        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
    </div>
{{--    <button type="button" class="ml-auto bg-white flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">--}}
{{--        <span class="sr-only">View notifications</span>--}}
{{--        <x-heroicon-o-bell class="h-6 w-6" />--}}
{{--    </button>--}}
</div>

<div class="mt-5">
    @can('profiles update')
        <a href="{{ route('admin.profiles.edit', ['profile' => Auth::user()]) }}" class="nav-item">
            Profile
        </a>
    @endcan

    @foreach(config('navigation._profile') as $name => $navigationGroup)
        <div class="nav-item">
            @include('voiler::layouts.navigation.nav-item', [
                'name' => $name,
                'navigationGroup' => $navigationGroup,
            ])
        </div>
    @endforeach

    <a href="#" class="nav-item" onclick="document.getElementById('logout-form').submit();">
        Sign out
    </a>
</div>
