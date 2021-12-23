@if(isset($navigationGroup['route']))
    {{-- Single page --}}
    {{--TODO Missing policy check--}}
    <a href="{{ route($navigationGroup['route']) }}" aria-current="page">
        {{ $name }}
    </a>
@else
    <div class="
        dropdown
        {{ isset($isSubmenu) && $isSubmenu ? 'submenu' : '' }}
        @if(isset($navigationGroup['direction']))
            {{ $navigationGroup['direction'] }}
        @else
            {{ isset($isSubmenu) && $isSubmenu ? 'direction-right-down' : 'direction-down-right' }}
        @endif
    ">
        <a class="{{ isset($isSubmenu) && $isSubmenu ? 'menuitem' : '' }}" href="#" aria-current="page" aria-expanded="false" aria-haspopup="true">
            @if(isset($isSubmenu) && $isSubmenu)
                {{ $name }}
                <x-heroicon-s-chevron-right class="h-5 w-3" />
            @else
                <span class="inline-flex justify-center">
                    {{ $name }}
                    <x-heroicon-s-chevron-down class="ml-1 h-5 w-3" />
                </span>
            @endif
        </a>

        <div
            class="hidden dropdown-menu"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="menu-button"
            tabindex="-1"
        >
            @if(isset($navigationGroup[0]['route']))
                {{-- Single dropdown --}}
                @foreach($navigationGroup as $key => $item)
                    @if(in_array($key, ['can', 'direction']))
                        @continue
                    @endif

                    <a href="{{ route($item['route']) }}" class="menuitem">
                        {{ $item['name'] }}
                    </a>
                @endforeach
            @else
                {{-- Recursive dropdown --}}
                @foreach($navigationGroup as $subName => $subNavigationGroup)
                    @if(in_array($subName, ['can', 'direction']))
                        @continue
                    @endif

                    @include('voiler::layouts.navigation.item', [
                        'name' => $subName,
                        'navigationGroup' => $subNavigationGroup,
                        'isSubmenu' => true,
                    ])
                @endforeach
            @endif
        </div>
    </div>
@endif