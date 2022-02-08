@foreach(config('navigation._pages') as $name => $navigationGroup)
    <div class="nav-item {{ str_contains(print_r($navigationGroup, true), Route::currentRouteName()) ? 'active' : '' }}">
        @include('voiler::layouts.navigation.item', [
            'name' => $name,
            'navigationGroup' => $navigationGroup,
        ])
    </div>
@endforeach