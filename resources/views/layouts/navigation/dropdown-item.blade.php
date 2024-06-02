@if(! isset($navigationGroup['can']) || Auth::user()->can($navigationGroup['can']))
    @if(isset($navigationGroup['route']))
        {{-- single page --}}
        <a href="{{ route($navigationGroup['route']) }}" class="dropdown-item" aria-current="page">
            {{ __($name) }}
        </a>
    @else
        <li>
            <a
                class="{{ isset($isSubmenu) && $isSubmenu ? 'dropdown-item' : '' }}"
                href="#"
                aria-current="page"
                aria-expanded="false"
                aria-haspopup="true"
            >
                @if(isset($isSubmenu) && $isSubmenu)
                    {{ __($name) }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-3" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                @else
                    <span class="inline-flex justify-center">
                        {{ __($name) }}
                        <svg
                            xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 w-3" viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </span>
                @endif
            </a>
            
            <div class="submenu dropdown-menu">
                @if(isset($navigationGroup[0]['route']))
                    {{-- Single dropdown --}}
                    @foreach($navigationGroup as $key => $item)
                        @if('can' === $key)
                            @continue
                        @endif
                        
                        @if(! isset($item['can']) || Auth::user()->can($item['can']))
                            <a href="{{ route($item['route']) }}" class="dropdown-item">
                                {{ __($item['name']) }}
                            </a>
                        @endif
                    @endforeach
                @else
                    {{-- Recursive dropdown --}}
                    @foreach($navigationGroup as $subName => $subNavigationGroup)
                        @if('can' === $subName)
                            @continue
                        @endif
                        
                        @include('voiler::layouts.navigation.dropdown-item', [
                            'name' => $subName,
                            'navigationGroup' => $subNavigationGroup,
                            'isSubmenu' => true,
                        ])
                    @endforeach
                @endif
            </div>
        </li>
    @endif
@endif
