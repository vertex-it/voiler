<nav class="flex justify-between">
    @foreach(config('navigation') as $name => $navigationGroup)
        @if (isset($navigationGroup['route']))
            <div class="mx-5 font-medium text-sm text-gray-700 tracking-wide">
                <a href="{{ route($navigationGroup['route']) }}" class="py-5 flex items-center">
                    {!! $navigationGroup['icon'] !!}
                    {{ $name }}
                </a>
            </div>
        @else
            <div class="mx-5 font-medium text-sm text-gray-700 tracking-wide">
                <a href="#" class="py-5 flex items-center btn-click-dropdown">
                    {!! $navigationGroup['icon'] !!}
                    {{ $name }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" class="ml-0.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <nav class="dropdown mt-3 hidden">
                    @foreach ($navigationGroup['pages'] as $pageName => $page)
                        @if (isset($page['route']))
                            <a href="{{ route($page['route']) }}" class="item">
                                {{ $pageName }}
                            </a>
                        @else
                            @if(! isset($page['can']) || Auth::user()->can($page['can']))
                                <div class="item has-submenu btn-open-dropdown">
                                    <div class="flex justify-between items-baseline ">
                                        {{ $pageName }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                    <div class="dropdown dropdown-level-2 hidden">
                                        @foreach ($page as $route)
                                            @if (isset($route['route']))
                                                @if(! isset($route['can']) || Auth::user()->can($route['can']))
                                                    <a href="{{ route($route['route']) }}" class="item">
                                                        {{ $route['name'] }}
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </nav>
            </div>
        @endif
    @endforeach
</nav>
