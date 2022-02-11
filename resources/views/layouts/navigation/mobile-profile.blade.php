<div class="flex items-center px-4">
    <div class="flex-shrink-0">
        <img class="h-10 w-10 rounded-full" src="http://placeimg.com/100/100/animals" alt="">
    </div>
    <div class="ml-3">
        <div class="text-base font-medium text-gray-800">{{ Auth::user()->getTitle() }}</div>
        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
    </div>
    <button type="button" class="ml-auto bg-white flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span class="sr-only">View notifications</span>
        <x-heroicon-o-bell class="h-6 w-6" />
    </button>
</div>

<div class="mt-3 space-y-1">
    @can('profiles update')
        <a href="{{ route('admin.profiles.edit', ['profile' => Auth::user()]) }}" class="nav-mobile-item">
            Profile
        </a>
    @endcan

    @foreach(config('navigation._profile') as $name => $navigationGroup)
        <div class="nav-mobile-item">
            @include('voiler::layouts.navigation.mobile-item', [
                'name' => $name,
                'navigationGroup' => $navigationGroup,
            ])
        </div>
    @endforeach

    <a href="#" class="nav-mobile-item" onclick="document.getElementById('logout-form').submit();">
        Sign out
    </a>
</div>