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
                <a href="#" class="py-5 flex items-center btn-open-dropdown">
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
                            <div class="item has-submenu">
                                <div class="flex justify-between items-baseline btn-open-dropdown">
                                    {{ $pageName }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                                <div class="dropdown dropdown-level-2 hidden">
                                    @foreach ($page as $route)
                                        <a href="{{ route($route['route']) }}" class="item">
                                            {{ $route['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </nav>
            </div>
        @endif
    @endforeach
</nav>

@once
    @push('scripts')
        <script>
            $('header').delegate('.btn-open-dropdown', 'click', function () {
                $(this).parent().find('.dropdown').first().toggleClass('hidden')
            })
        </script>
    @endpush
@endonce
