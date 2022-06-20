{{-- TODO Documentation --}}
{{-- Keep in mind this view is used for recursive dropdown navigation! --}}

@if(! isset($navigationGroup['can']) || Auth::user()->can($navigationGroup['can']))
    @if(isset($navigationGroup['route']))
        {{-- Single page --}}
        <a class="single-page" href="{{ route($navigationGroup['route']) }}" aria-current="page">
            {{ $name }}
        </a>
    @else
        <div class="dropdown {{ isset($isSubmenu) && $isSubmenu ? 'submenu' : '' }} direction-down-right">
            <a
                class="flex {{ isset($isSubmenu) && $isSubmenu ? 'menuitem' : '' }}"
                href="#"
                aria-current="page"
                aria-expanded="false"
                aria-haspopup="true"
            >
                <span class="inline-flex justify-center">
                    {{ $name }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 w-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
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

                        @include('voiler::layouts.navigation.nav-item', [
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
