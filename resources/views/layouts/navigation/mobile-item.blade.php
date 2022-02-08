{{-- TODO Documentation --}}
{{-- Keep in mind this view is used for recursive dropdown navigation! --}}

@if(! isset($navigationGroup['can']) || Auth::user()->can($navigationGroup['can']))
    @if(isset($navigationGroup['route']))
        {{-- Single page --}}
        <a href="flex {{ route($navigationGroup['route']) }}" aria-current="page">
            {{ $name }}
        </a>
    @else
        <div class="dropdown {{ isset($isSubmenu) && $isSubmenu ? 'submenu' : '' }} direction-down-right">
            <a class="flex {{ isset($isSubmenu) && $isSubmenu ? 'menuitem' : '' }}" href="#" aria-current="page" aria-expanded="false" aria-haspopup="true">
                <span class="inline-flex justify-center">
                    {{ $name }}
                    <x-heroicon-s-chevron-down class="ml-1 h-5 w-3" />
                </span>
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

                        @if(! isset($item['can']) || Auth::user()->can($item['can']))
                            <a href="{{ route($item['route']) }}" class="menuitem">
                                {{ $item['name'] }}
                            </a>
                        @endif
                    @endforeach
                @else
                    {{-- Recursive dropdown --}}
                    @foreach($navigationGroup as $subName => $subNavigationGroup)
                        @if(in_array($subName, ['can', 'direction']))
                            @continue
                        @endif

                        @include('voiler::layouts.navigation.mobile-item', [
                            'name' => $subName,
                            'navigationGroup' => $subNavigationGroup,
                            'isSubmenu' => true,
                        ])
                    @endforeach
                @endif
            </div>
        </div>
    @endif
@endif