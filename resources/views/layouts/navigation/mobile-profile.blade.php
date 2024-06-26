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
</div>

<div class="mt-5">
    @can('Profile update')
        <a
            href="{{ route('admin.profiles.edit', ['profile' => Auth::user()]) }}"
            class="nav-item {{ Route::currentRouteName() === 'admin.profiles.edit' ? 'active' : '' }}"
        >
            {{ __('Profile') }}
        </a>
    @endcan

    @include('voiler::layouts.navigation.nav', [
        'navigation' => config('navigation._profile'),
    ])

    <a href="#" class="nav-item" onclick="document.getElementById('logout-form').submit();">
        {{ __('Sign out') }}
    </a>
</div>
