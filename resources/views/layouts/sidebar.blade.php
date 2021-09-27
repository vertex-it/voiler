<div class="sidebar">
    <div class="h-16 px-12 pt-8 pb-14">
        <a href="#">
            <h2 class="logo">{{ config('app.name') }}</h2>
        </a>
    </div>
    <nav class="sticky top-0">
        <ul class="sidebar-nav">
            @foreach (config('navigation') as $key => $section)
                @if (! isset($section['role']) || Auth::user()->hasRole($section['role']))
                    @if (! isset($section['can']) || Auth::user()->can($section['can']))
                        @if ($key !== 'without-title')
                            <li class="item-group">
                                {{ __($key) }}
                            </li>
                        @endif

                        @foreach($section as $name => $page)
                            @if (isset($page['route']))
                                <li class="item {{ Route::currentRouteName() === $page['route'] ? 'active' : '' }}">
                                    <a href="{{ route($page['route']) }}">
                                        {{ __($name) }}
                                    </a>
                                </li>
                            @else
                                <li class="item has-submenu {{ in_array(
                                    Route::currentRouteName(),
                                    array_merge(
                                        array_column($page['routes'], 'route'),
                                        $page['hidden_routes'] ?? []
                                    )
                                ) ? 'active' : ''
                                }}">
                                    <a href="#">
                                        {{ __($name) }}
                                        <svg width="15" height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <ul class="submenu">
                                        @foreach($page['routes'] as $route)
                                            <li class="{{ Route::currentRouteName() === $route['route'] ? 'active' : '' }}">
                                                <a href="{{ route($route['route']) }}" class="item submenu-item">
                                                    {{ __($route['name']) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endif
            @endforeach
        </ul>
    </nav>
</div>
