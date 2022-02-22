<div class="ml-3 dropdown direction-down-left">
    <a href="#" aria-current="page" aria-expanded="false" aria-haspopup="true">
        <span class="sr-only">Open user menu</span>
        <img class="h-8 w-8 rounded-full" src="http://placeimg.com/100/100/animals" alt="">
    </a>

    <div
        class="hidden dropdown-menu"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="menu-button"
        tabindex="-1"
    >
        @can('profiles update')
            <a href="{{ route('admin.profiles.edit', ['profile' => Auth::user()]) }}" class="menuitem">
                Profile
            </a>
        @endcan

        @foreach(config('navigation._profile') as $name => $navigationGroup)
            @include('voiler::layouts.navigation.item', [
                'name' => $name,
                'navigationGroup' => $navigationGroup,
                'isSubmenu' => true,
            ])
        @endforeach

        <a href="#" class="menuitem" onclick="document.getElementById('logout-form').submit();">
            Sign out
        </a>
    </div>
</div>
