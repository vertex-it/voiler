@foreach(config('navigation._pages') as $name => $navigationGroup)
    {{-- TODO Add active route check --}}
    <div class="nav-mobile-item {{ false ? 'active' : '' }}">
        @include('voiler::layouts.navigation.mobile-item', [
            'name' => $name,
            'navigationGroup' => $navigationGroup,
        ])
    </div>
@endforeach