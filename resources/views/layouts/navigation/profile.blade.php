<div class="ml-3 dropdown">
    <button class="btn btn-transparent p-2 rounded-full dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="sr-only">
            {{ __('Open user menu') }}
        </span>
        
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
        </svg>
    </button>
    
    <ul class="dropdown-menu dropdown-menu-right">
        @can('profiles update')
            <a href="{{ route('admin.profiles.edit', ['profile' => Auth::user()]) }}" class="dropdown-item">
                {{ __('Profile') }}
            </a>
        @endcan
        
        @foreach(config('navigation._profile') as $name => $navigationGroup)
            @include('voiler::layouts.navigation.dropdown-item', [
                'name' => $name,
                'navigationGroup' => $navigationGroup,
                'isSubmenu' => true,
            ])
        @endforeach
        
        <a href="#" class="dropdown-item" onclick="document.getElementById('logout-form').submit();">
            {{ __('Sign out') }}
        </a>
    </ul>
</div>
