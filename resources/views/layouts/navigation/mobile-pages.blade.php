@foreach(config('navigation._pages') as $name => $navigationGroup)
    <div class="nav-mobile-item {{ str_contains(print_r($navigationGroup, true), Route::currentRouteName()) ? 'active' : '' }}">
        @include('voiler::layouts.navigation.mobile-item', [
            'name' => $name,
            'navigationGroup' => $navigationGroup,
        ])
    </div>
@endforeach