@foreach(config('navigation._pages') as $name => $navigationGroup)
    @if(isset($navigationGroup['label']))
        <div class="nav-label">
            {{ $name }}
        </div>
        @continue
    @endif

    <div class="nav-item {{ str_contains(print_r($navigationGroup, true), Route::currentRouteName()) ? 'active' : '' }}">
        @include('voiler::layouts.navigation.nav-item', [
            'name' => $name,
            'navigationGroup' => $navigationGroup,
        ])
    </div>
@endforeach
