@foreach(config('navigation._pages') as $name => $navigationGroup)
        {{-- TODO Add active route check --}}
        <div class="nav-item {{ false ? 'active' : '' }}">
            @include('voiler::layouts.navigation.item', [
                'name' => $name,
                'navigationGroup' => $navigationGroup,
            ])
        </div>
@endforeach